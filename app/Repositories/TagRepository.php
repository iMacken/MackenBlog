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

	public function get($name)
	{
		$tag = $this->remember('tag.one.' . $name, function () use ($name) {
			return Tag::where('name', $name)->firstOrFail();
		});
		return $tag;
	}

	public function pagedArticlesByTag(Tag $tag, $limit = 7)
	{
		$articles = $this->remember('tag.articles.' . $tag->name . $limit . request()->get('page', 1), function () use ($tag, $limit) {
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
}