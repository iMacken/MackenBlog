<?php
namespace App\Repositories;

use App\Article;
use App\Http\Requests\TagRequest;
use App\Tag;

/**
 * Class TagRepository
 * @package App\Http\Repository
 */
class TagRepository extends Repository
{
	static $tag = 'tag';

	public function tag()
	{
		return TagRepository::$tag;
	}

	public function model()
	{
		return app(Tag::class);
	}

	public function getAll()
	{
		$tags = $this->remember('tag.all', function () {
			return Tag::withCount('articles')->get();
		});
		return $tags;
	}

	public function get($slug)
	{
		$tag = $this->remember('tag.one.' . $slug, function () use ($slug) {
			return Tag::where('slug', $slug)->firstOrFail();
		});
		return $tag;
	}

	public function pagedArticlesByTag(Tag $tag, $limit = Tag::PAGE_LIMIT)
	{
		$articles = $this->remember('tag.articles.' . $tag->slug . $limit . request()->get('page', 1), function () use ($tag, $limit) {
			return $tag->articles()->select(Article::INDEX_FIELDS)->with(['tags', 'category'])->withCount('comments')->orderBy('published_at', 'desc')->paginate($limit);
		});
		return $articles;
	}

	public function create(TagRequest $request)
	{
		$this->clearCache();

		$tag = Tag::create(['name' => $request['name']]);
		return $tag;
	}

	public function update(TagRequest $request)
	{
		$this->clearCache();

		$tag = Tag::create(['name' => $request['name']]);
		return $tag;
	}

	/**
	 * @param int $count
	 * @return mixed
	 */
	public function hot($count = 12)
	{
		$tags = $this->remember('tag.hot.' . $count, function () use ($count) {
			return Tag::select([
				'name',
				'slug',
				'cited_count',
			])->orderBy('click_count', 'desc')->limit($count)->get();
		});
		return $tags;
	}
}