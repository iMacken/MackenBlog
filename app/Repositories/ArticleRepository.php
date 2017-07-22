<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Tag;
use App\Services\MarkdownParser;
use Illuminate\Support\Facades\DB;

class ArticleRepository
{
	use BaseRepositoryTrait, PaginateRepositoryTrait;

	protected $markdownParser;
	protected $tagRepository;

	protected $model;

	public function __construct(Article $model, MarkdownParser $markdownParser, TagRepository $tagRepository)
	{
		$this->model = $model;
		$this->markdownParser = $markdownParser;
		$this->tagRepository = $tagRepository;
	}

	public function get($slug)
    {
		$article = Article::where('slug', $slug)->with(['tags', 'category'])->withCount('comments')->firstOrFail();
		DB::table('articles')->where('id', $article->id)->increment('view_count');

		return $article;
	}

	public function getById($id)
	{
		return Article::withoutGlobalScopes()->with(['tags', 'category'])->withCount('comments')->findOrFail($id);
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
			return self::select(['id','title','slug','content','created_at','category_id'])
                			->where(DB::raw("DATE_FORMAT(`created_at`, '%Y %c')"), '=', "$year $month")
                			->where('category_id', '<>', 0)
                			->latest()
                			->paginate($limit);
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

		/** @var Article $article */
		$article = auth()->user()->articles()->create(
			array_merge(
				$data,
				[
					'html_content' => $this->markdownParser->convertMarkdownToHtml($data['content'], false),
				]
			)
		);

		$article->save(); # save it in scout

		$this->syncTags($article, $data['tag_list']);

		$article->saveConfig($data);

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

		/** @var Article $article */
		$article = $this->getById($id);

		$this->syncTags($article, $data['tag_list']);

		$article->saveConfig($data);

		$result = $article->update(
			array_merge($data, [
			    'html_content' => $this->markdownParser->convertMarkdownToHtml($data['content'], false)
            ])
		);

		$result && $article->save(); # update it in scout

		return $result;
	}

	public function delete($id)
	{
		$this->clearAllCache();
		/** @var Article $article */
		$article = $this->getById($id);
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
