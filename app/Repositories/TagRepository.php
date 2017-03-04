<?php
namespace App\Repositories;

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
			return Tag::withCount('posts')->get();
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

	public function pagedPostsByTag(Tag $tag, $page = 7)
	{
		$posts = $this->remember('tag.posts.' . $tag->name . $page . request()->get('page', 1), function () use ($tag, $page) {
			return $tag->posts()->select(Post::selectArrayWithOutContent)->with(['tags', 'category'])->withCount('comments')->orderBy('created_at', 'desc')->paginate($page);
		});
		return $posts;
	}

	public function create(Request $request)
	{
		$this->clearCache();

		$tag = Tag::create(['name' => $request['name']]);
		return $tag;
	}
}