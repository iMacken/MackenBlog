<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\TagRepository;
use App\Http\Requests\ArticleRequest;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

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
        $jumbotron['description']  = config('blog.default_motto');

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
	    Mail::send('mail.test',['name'=>'test'],function($message){
		    $to = '615170821@qq.com';
		    $message ->to($to)->subject('测试邮件');
	    });
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
	    return view('article.create', [
		    'categories' => $this->categoryRepository->getAll(),
		    'tags' => $this->tagRepository->getAll(),
	    ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest $request
     * @return Response
     */
    public function store(ArticleRequest $request)
    {
	    $article = $this->articleRepository->create($request);

	    if (!$article) {
		    return redirect()->back()->withErrors('创建失败')->withInput();
	    }

	    return redirect()->route('article.show', ['slug' => $request->input('slug')])->with('success', '创建成功');
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
	    $this->authorize('update', $this->articleRepository->getById($id));

	    $result = $this->articleRepository->update($request, $id);

	    if ($result) {
		    return redirect()->route('article.show', ['slug' => $request->input('slug')])->with('success', '更新成功');
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
	    $this->authorize('delete', $this->articleRepository->getById($id));

	    $result = $this->articleRepository->delete($id);

        if ($result) {
	        return redirect()->route('article.index')->with('success', '更新成功');
        } else {
	        return redirect()->back()->withErrors('删除失败');
        }
    }

	public function search(Request $request)
	{
		$keyword = trim($request->input('keyword'));
		if (! $keyword) {
			return redirect()->route('article.index');
		}

		$articles = $this->articleRepository->search($keyword);

		$jumbotron = [];
		$jumbotron['title'] = '关键词：' . $keyword;
		$jumbotron['desc'] = '';

		return view('article.search', compact('keyword', 'articles', 'jumbotron'));
	}
}
