<?php

namespace App\Repositories;

use App\Http\Requests\ArticleRequest;
use App\Services\Markdowner;
use Model, DB;

class ArticleRepository extends Repository
{
	protected $markdowner;

	static $tag = 'article';

	/**
	 * ArticleRepository constructor.
	 * @param Markdowner $markdowner
	 */
	public function __construct(Markdowner $markdowner)
	{
		$this->markdowner = $markdowner;
	}

	public function model()
	{
		return app(Article::class);
	}

	public function tag()
	{
		return ArticleRepository::$tag;
	}

	public function count()
	{
		$count = $this->remember($this->tag() . '.count', function () {
			return $this->model()->withoutGlobalScopes()->count();
		});
		return $count;
	}

	/**
	 * @param int $page
	 * @return mixed
	 */
	public function pagedArticlesWithoutGlobalScopes($page = 15)
	{
		$articles = $this->remember('articles.withoutContent.page.' . $page . '' . request()->get('page', 1), function () use ($page) {
			return Article::withoutGlobalScopes()->withCount('comments')->orderBy('created_at', 'desc')->select(Article::INDEX_FIELDS)->with(['tags', 'category'])->paginate($page);
		});
		return $articles;
	}

	/**
	 * @param int $page
	 * @return mixed
	 */
	public function pagedArticles($page = 10)
	{
		$articles = $this->remember('articles.page.' . $page . '' . request()->get('page', 1), function () use ($page) {
			return Article::select(Article::INDEX_FIELDS)->with(['tags', 'category'])->withCount('comments')->orderBy('published_at', 'desc')->paginate($page);
		});
		return $articles;
	}

	/**
	 * @param $slug string
	 * @return Article
	 */
	public function get($slug)
	{
		$article = $this->remember('article.one.' . $slug, function () use ($slug) {
			return Article::where('slug', $slug)->with(['tags', 'category', 'configuration'])->withCount('comments')->firstOrFail();
		});
		return $article;
	}

	public function hot($count = 5)
	{
		$articles = $this->remember('article.hot.' . $count, function () use ($count) {
			return Article::select([
				'title',
				'slug',
				'view_count',
			])->withCount('comments')->orderBy('view_count', 'desc')->limit($count)->get();
		});
		return $articles;
	}

	public function achieve()
	{
		$articles = $this->remember('article.achieve', function () use ($limit) {
			return Model::select(DB::raw("DATE_FORMAT(`created_at`, '%Y %m') as `archive`, count(*) as `count`"))
				->where('category_id', '<>', 0)
				->groupBy('archive')
				->orderBy('archive', 'desc')
				->get();
		});
		return $articles;
	}

	/**
	 * @param ArticleRequest $request
	 * @return mixed
	 */
	public function create(ArticleRequest $request)
	{
		$this->clearAllCache();

		$article = auth()->user()->articles()->create(
			array_merge(
				$request->all(),
				[
					'html_content' => $this->markdowner->convertMarkdownToHtml($request->get('content'), false),
					'description' => $this->markdowner->convertMarkdownToHtml($request->get('description'), false),
				]
			)
		);

		$article->tags()->sync($request->get('tag_list'));

		
	}

    /**
     * Search the articles by the keyword.
     *
     * @param  string $key
     * @return collection
     */
    public function search($key)
    {
        $key = trim($key);

        return $this->model
                    ->where('title', 'like', "%{$key}%")
                    ->orderBy('published_at', 'desc')
                    ->get();

    }
}
