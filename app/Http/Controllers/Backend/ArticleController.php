<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input, Notification, Auth, Request, Cache, DB;
use App\Models\Article;
use App\Models\Category;
use App\Models\ArticleStatus;
use App\Http\Requests\ArticleRequest;
use App\Models\Tag;

class ArticleController extends Controller
{

    public function __construct()
    {

    }

    /**
     * index all articles with elasticsearch
     * @return [type] [description]
     */
    public function indexAll()
    {
        Article::createIndex($shards = null, $replicas = null);
        Article::addAllToIndex();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('backend.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categoryTree = Category::getCategoryTree();
        $categoryTree[0] = '单页';
        $tags = Tag::lists('name', 'id');
        return view('backend.article.create', compact('categoryTree', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ArticleRequest $request)
    {
        try {

            $pic = upload_file('pic', $request);
            !$pic && Notification::error('文章配图上传失败');

            $createData = $request->all();
            $createData['pic'] = $pic;
            $article = Auth::user()->articles()->create($createData);

            #add the new article into elasticsearch index
            $article && $article->addToIndex();

            if ($request->has('tag_list')) {
                $this->syncTags($article, $request->input('tag_list'));
            }

            if (ArticleStatus::initArticleStatus($article->id)) {
                Notification::success('文章发表成功');
                return redirect()->route('backend.article.index');
            } else {
                self::destroy($article->id);
            }

            return $article;
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return Article::select('content')->find($id)->content;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Article $article)
    {
        $tags = Tag::lists('name', 'id');
        $categoryTree = Category::getCategoryTree();
        $categoryTree[0] = '单页';
        return view('backend.article.edit', compact('article', 'categoryTree', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        try {

            $updateData = $request->all();

            if (Request::hasFile('pic'))
            {
                $pic = upload_file('pic', $request);
                !$pic && Notification::error('文章配图上传失败');
                $updateData['pic'] = $pic;
                $article->pic && $oldPic = public_path() . $article->pic;
            }

            if ($article->update($updateData))
            {
                #update the article in elasticsearch index
                $article->updateIndex();

                $this->syncTags($article, $request->input('tag_list'));

                Notification::success('更新成功');

                if (Request::hasFile('pic') && file_exists($oldPic)) {
                    @unlink($oldPic);
                }

                return redirect()->route('backend.article.index');
            }
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        
        if (ArticleStatus::deleteArticleStatus($id)) {

            if (Article::destroy($id)) {

                #remove the article from the elasticsearch index
                $article->removeFromIndex();

                Notification::success('删除成功');
                $this->deleteArticleImages($article);
            } else {
                Notification::error('主数据删除失败');
            }

        } else {

            Notification::error('动态删除失败');

        }

        return redirect()->route('backend.article.index');
    }

    /**
     * delete all images of the given article
     * @param  Article $article [description]
     * @return [type]           [description]
     */
    private function deleteArticleImages(Article $article)
    {
        $publicPath = public_path();

        if (!empty($article->pic)) {
            $fileName = $publicPath . $article->pic;
            if (file_exists($fileName)) {
                @unlink($fileName);
            }
        }

        preg_match_all('/\((.*?(png|jpg|jpeg|gif))\)/i', $article->content, $matches);
        $images = $matches[1];
        if (!empty($images)) {
            foreach ($images as $v) {
                @unlink($publicPath . $v);
            }
        }
    }

    /**
     * sync tags of the given article
     * @param  Article $article [description]
     * @param  array   $tags    [description]
     * @return [type]           [description]
     */
    private function syncTags(Article $article, array $tags) 
    {
        #extract the input into separate numeric and string arrays
        $currentTags = array_filter($tags, 'is_numeric'); # ["1", "3", "5"]
        $newTags = array_diff($tags, $currentTags); # ["awesome", "cool"]

        #Create a new tag for each string in the input and update the current tags array
        foreach ($newTags as $newTag)
        {
          if ($tag = Tag::firstOrCreate(['name' => $newTag]))
          {
             $currentTags[] = $tag->id;
          }
        }

        #recalculate the cited number of the tags related to the given article
        $oldTags = $article->tags()->get()->keyBy('id')->keys()->toArray();
        $decTags = array_diff($oldTags, $currentTags);
        $incTags = array_diff($currentTags, $oldTags);
        DB::table('tags')->whereIn('id', $incTags)->increment('number');
        DB::table('tags')->whereIn('id', $decTags)->decrement('number');

        #sync the pivot table of article_tag
        $article->tags()->sync($currentTags);
    }
}
