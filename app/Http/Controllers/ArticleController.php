<?php

namespace App\Http\Controllers;

use App\Facades\Toastr;
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
        $method = isAdmin() ? 'pagedArticlesWithoutGlobalScopes' : 'pagedArticles';
	    $articles = $this->articleRepository->{$method}();

        $jumbotron = [];
        $jumbotron['title'] = config('blog.default_owner');
        $jumbotron['description'] = config('blog.default_motto');

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
     * @return Response
     */
    public function archive($year, $month)
    {
        $articles = $this->articleRepository->archive(12);

        $jumbotron = [];
        $jumbotron['title'] = '归档：'.$year.'年 '.$month.'月';
        $jumbotron['desc'] = '陈列在时光里的记忆，拂去轻尘，依旧如新。';

        return view('pages.list', compact('articles', 'jumbotron'));
    }

    public function create()
    {
	    $this->authorize('create', Article::class);

	    return view('article.create', [
		    'categories' => $this->categoryRepository->getAll(),
		    'tags' => $this->tagRepository->getAll(),
	    ]);
    }

    public function store(ArticleRequest $request)
    {
	    $this->authorize('create', Article::class);

	    $article = $this->articleRepository->create($request->all());

	    if ($article) {
		    Toastr::success('文章创建成功');
		    return redirect()->route('article.show', ['slug' => $article->slug]);

	    }
	    Toastr::error('文章创建失败');

	    return redirect()->back()->withInput();
    }

    public function edit($id)
    {
	    return view('article.edit', [
		    'article' => $this->articleRepository->getById($id),
		    'categories' => $this->categoryRepository->getAll(),
		    'tags' => $this->tagRepository->getAll(),
	    ]);
    }

    public function update(ArticleRequest $request, $id)
    {
	    $this->authorize('update', $this->articleRepository->getById($id));

	    $result = $this->articleRepository->update($request->all(), $id);

	    if ($result) {
		    Toastr::success('文章更新成功');
		    return redirect()->route('article.show', ['slug' => $request->input('slug')]);
	    }
	    Toastr::error('文章更新失败');

	    return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
	    $this->authorize('delete', $this->articleRepository->getById($id));

	    $result = $this->articleRepository->delete($id);

        if ($result) {
	        Toastr::success('文章删除成功');
	        return redirect()->route('article.index');
        }
	    Toastr::success('文章删除失败');

	    return redirect()->back();
    }

	public function search(Request $request)
	{
		$keyword = trim($request->input('keyword'));
		if (! $keyword) {
			return redirect()->route('article.index');
		}

		$articles = $this->articleRepository->search($keyword);

		return view('article.search', compact('keyword', 'articles'));
	}
}
