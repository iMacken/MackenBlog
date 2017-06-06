<?php
namespace App\Repositories;

use App\Article;
use App\Tag;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

	public function create($data)
	{
		$this->clearCache();

		$tag = Tag::create($data);

		return $tag;
	}

	public function update(array $data, $id)
	{
		$this->clearCache();

		/** @var Tag $tag */
		$tag = $this->model()->findOrFail($id);
		$tag = $tag->update($data);

		return $tag;
	}

	public function getById($id)
	{
		return $this->model()->findOrFail($id);
	}

	public function delete($id)
	{
		$this->clearCache();
		/** @var Tag $tag */
		$tag = $this->model()->find($id);

		if ($tag->articles()->withoutGlobalScopes()->count() > 0) {
			throw new AccessDeniedHttpException('该标签下有文章,不能删除');
		}

		return $tag->destroy($id);
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
