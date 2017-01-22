<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Article;

use Parsedown;

class ArticleController extends Controller
{

    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;

	    $this->middleware(['auth', 'admin'], ['except' => ['show', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
	    $articles = $this->article->page(config('blog.article.number'), config('blog.article.sort'), config('blog.article.sortColumn'));

        $jumbotron = [];
        $jumbotron['title'] = config('blog.default_owner');
        $jumbotron['desc']  = config('blog.default_motto');

        return view('article.index', compact('articles', 'jumbotron'));
    }


    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return Response
     */
    public function show($slug)
    {
        $article = $this->article->getBySlug($slug);
        return view('article.show', compact('article'));
    }

    /**
     * display the articles archived by month
     * @param  [type] $year  [description]
     * @param  [type] $month [description]
     * @return [type]        [description]
     */
    public function archive($year, $month)
    {
        $articles = Article::getArchivedArticleList($year, $month, 8);

        $jumbotron = [];
        $jumbotron['title'] = '归档：'.$year.'年 '.$month.'月';
        $jumbotron['desc'] = '陈列在时光里的记忆，拂去轻尘，依旧如新。';

        return view('pages.list', compact('articles', 'jumbotron'));
    }

    /**
     * index all articles with elasticsearch
     * @return [type] [description]
     */
    public function indexAll()
    {
        if (Article::typeExists()) {
            Article::deleteIndex();
        }
        Article::createIndex($shards = null, $replicas = null);
        Article::addAllToIndex();
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
        $tags = Tag::pluck('name', 'id');
        return view('article.create', compact('categoryTree', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest $request
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
            if (config('elasticquent.elasticsearch')) {
                $article && $article->addToIndex();
            }

            if ($request->has('tag_list')) {
                $this->syncTags($article, $request->input('tag_list'));
            }

            if (ArticleStatus::initArticleStatus($article->id)) {
                Notification::success('文章发表成功');
                return redirect()->route('article.index');
            } else {
                self::destroy($article->id);
            }

            return $article;

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Article $article
     * @return Response
     */
    public function edit(Article $article)
    {
//        $tags = Tag::pluck('name', 'id');

        $this->checkPolicy('update', $article);

	    $categories = $this->categoryRepository->getAll();
	    $tags       = $this->tagRepository->getAll();

        return view('article.edit', [
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleRequest $request
     * @param  Article $article
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
                if (config('elasticquent.elasticsearch')) {
                    $article->updateIndex();
                }

                $this->syncTags($article, $request->input('tag_list'));

                Notification::success('更新成功');

                if (Request::hasFile('pic') && file_exists($oldPic)) {
                    @unlink($oldPic);
                }

                return redirect()->route('article.index');
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

        return redirect()->route('article.index');
    }

    /**
     * delete all images of the given article
     * @param  Article $article [description]
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
