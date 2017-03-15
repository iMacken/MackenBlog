<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\TagRepository;
use App\Http\Requests\ArticleRequest;

use App\Article;
use DB;
use Auth;

class ArticleController extends Controller
{

    protected $articleRepository;
    protected $categoryRepository;
    protected $tagRepository;
    protected $model;

    public function __construct(ArticleRepository $articleRepository,
                                CategoryRepository $categoryRepository,
                                TagRepository $tagRepository,
								Article $article)
    {
        $this->articleRepository  = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository      = $tagRepository;

	    $this->middleware(['auth', 'admin'], ['except' => ['show', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
	    $articles = $this->articleRepository->pagedArticles();

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
	    $article = $this->articleRepository->get($slug);

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
	    $categories = $this->categoryRepository->pluck('name', 'id');
	    $tags       = $this->tagRepository->pluck('name', 'id');

	    return view('article.create', compact('article', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest $request
     * @return Response
     */
    public function store(ArticleRequest $request)
    {
	    $article = $this->articleRepository->create($request->all());

	    if (!$article) {
		    return redirect()->back()->withErrors('发布失败')->withInput();
	    }

	    #add the new article into elasticsearch index
	    if (config('elasticquent.elasticsearch')) {
		    $article->addToIndex();
	    }

	    $this->articleRepository->syncTags($request->input('tag_list'));

	    return redirect()->route('article.show', ['slug' => $request->input('slug')])->with('success', '更新成功');
    }


    /**
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
	    return view('article.edit', [
		    'article' => $this->articleRepository->getById($id),
		    'categories' => $this->categoryRepository->getAll(),
		    'tags' => $this->tagRepository->getAll(),
	    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(ArticleRequest $request, $id)
    {
	    $result = $this->articleRepository->updateRich($request->all(), $id);

	    if ($result) {
		    $this->articleRepository->syncTags($request->input('tag_list'));
		    return redirect()->route('article.show', ['slug' => $request->input('slug')])->with('success', '更新成功');
		    #update the article in elasticsearch index
		    if (config('elasticquent.elasticsearch')) {
			    $this->model->updateIndex();
		    }
	    }
	    return redirect()->back()->withErrors('更新失败')->withInput();
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
            } else {
                Notification::error('主数据删除失败');
            }

        } else {

            Notification::error('动态删除失败');

        }

        return redirect()->route('article.index');
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
