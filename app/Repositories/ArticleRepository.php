<?php

namespace App\Repositories;

use App\Article;
use App\Tag;
use App\Http\Requests\ArticleRequest;
use App\Services\MarkdownParser;
use DB;

class ArticleRepository extends Repository
{
	protected $markdownParser;
	protected $tagRepository;

	static $tag = 'article';

	/**
	 * ArticleRepository constructor.
	 * @param MarkdownParser $markdownParser
	 * @param TagRepository $tagRepository
	 */
	public function __construct(MarkdownParser $markdownParser, TagRepository $tagRepository)
	{
		$this->markdownParser    = $markdownParser;
		$this->tagRepository = $tagRepository;
	}

	/**
	 * @return \Illuminate\Foundation\Application|mixed
	 */
	public function model()
	{
		return app(Article::class);
	}

	/**
	 * @return string
	 */
	public function tag()
	{
		return ArticleRepository::$tag;
	}

	/**
	 * @return mixed
	 */
	public function count()
	{
		$count = $this->remember($this->tag() . '.count', function () {
			return $this->model()->withoutGlobalScopes()->count();
		});
		return $count;
	}

	/**
	 * @param int $limit
	 * @return mixed
	 */
	public function pagedArticlesWithoutGlobalScopes($limit = 15)
	{
		$articles = $this->remember('articles.withoutContent.page.' . $limit . '' . request()->get('page', 1), function () use ($limit) {
			return Article::withoutGlobalScopes()->withCount('comments')->orderBy('created_at', 'desc')->select(Article::INDEX_FIELDS)->with(['tags', 'category'])->paginate($limit);
		});
		return $articles;
	}

	/**
	 * @param int $limit
	 * @return mixed
	 */
	public function pagedArticles($limit = 10)
	{
		$articles = $this->remember('articles.page.' . $limit . '' . request()->get('page', 1), function () use ($limit) {
			return Article::select(Article::INDEX_FIELDS)->with(['tags', 'category'])->withCount('comments')->orderBy('published_at', 'desc')->paginate($limit);
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
			return Article::where('slug', $slug)->with(['tags', 'category'])->withCount('comments')->firstOrFail();
		});
		return $article;
	}

	public function getById($id)
	{
		return Article::with(['tags', 'category'])->withCount('comments')->findOrFail($id);
	}

	/**
	 * @param int $count
	 * @return mixed
	 */
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

	/**
	 * @param int $limit
	 * @return mixed
	 */
	public function archive($limit = 12)
	{
		$articles = $this->remember('article.achieve', function () use ($limit) {
			return Article::select(DB::raw("DATE_FORMAT(`created_at`, '%Y %m') as `archive`, count(*) as `count`"))
				->where('category_id', '<>', 0)
				->groupBy('archive')
				->orderBy('archive', 'desc')
				->get($limit);
		});
		return $articles;
	}

	/**
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data)
	{
		$this->clearAllCache();

		$article = auth()->user()->articles()->create(
			array_merge(
				$data,
				[
					'html_content' => $this->markdownParser->convertMarkdownToHtml($data['content'], false),
					'excerpt' => $this->markdownParser->convertMarkdownToHtml($data['excerpt'], false),
				]
			)
		);

		$article->save(); # save it in scout

		$this->syncTags($article, $data['tag_list']);

		return $article;
	}

	/**
	 * @param array
	 * @param int $id
	 * @return mixed
	 */
	public function update(array $data, $id)
	{
		$this->clearAllCache();

		$article = $this->model()->find($id);

		$this->syncTags($article, $data['tag_list']);

		$result = $article->update(
			array_merge(
				$data,
				[
					'html_content' => $this->markdownParser->convertMarkdownToHtml($data['content'], false),
					'description' => $this->markdownParser->convertMarkdownToHtml($data['description'], false),
				]
			)
		);

		$result && $article->save(); # update it in scout

		return $result;
	}

	/**
	 * @param $id
	 */
	public function delete($id)
	{
		$this->clearAllCache();

		$article = $this->model()->find($id);
		$result = $article->destroy($id);

		$result && $article->delete(); # delete from scout

		return $result;
	}

    /**
     *
     * @param  string $keyword
     * @return collection
     */
    public function search($keyword)
    {
	    if (env('SCOUT_DRIVER')) {
			return $this->model()->search($keyword)->paginate();
	    } else {
		    $keyword = trim($keyword);
		    return $this->model()
			    ->where('title', 'like', "%{$keyword}%")
			    ->orWhere('content', 'like', "%{$keyword}%")
			    ->orderBy('published_at', 'desc')
			    ->get();
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
		DB::table('tags')->whereIn('id', $incTags)->increment('cited_count');
		DB::table('tags')->whereIn('id', $decTags)->decrement('cited_count');

		#sync the pivot table of article_tag
		$article->tags()->sync($currentTags);
	}
}
