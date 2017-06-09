<?php

namespace App\Repositories;

use App\Article;
use App\Http\Requests\CategoryRequest;
use App\Category;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


class CategoryRepository extends Repository
{
	static $tag = 'category';

	public function tag()
	{
		return CategoryRepository::$tag;
	}

	public function model()
	{
		return app(Category::class);
	}

	public function getAll()
	{
		$categories = $this->remember('category.all', function () {
			return Category::withCount('articles')->get();
		});
		return $categories;
	}

	public function get($slug)
	{
		$category = $this->remember('category.one.' . $slug, function () use ($slug) {
			return Category::where('slug', $slug)->first();
		});

		! $category && abort(404);

		return $category;
	}

	public function getById($id)
	{
		return $this->model()->findOrFail($id);
	}

	public function pagedArticlesByCategory(Category $category, $limit = Category::PAGE_LIMIT)
	{
		$cacheKey = 'articles.category.' . $category->slug . '.page.' . $limit . request()->get('page', 1);
		$articles = $this->remember($cacheKey, function () use ($category, $limit) {
			return $category->articles()
					->select(Article::INDEX_FIELDS)
					->with(['tags', 'category'])
					->withCount('comments')
					->orderBy('created_at', 'desc')
					->paginate($limit);
		});
		return $articles;
	}

	public function create(array $data)
	{
		$this->clearCache();

		$category = Category::create($data);

		return $category;
	}

	public function update(array $data, $id)
	{
		$this->clearCache();

		/** @var Category $category */
		$category = $this->model()->find($id);

		return $category->update($data);
	}

	public function delete($id)
	{
		$this->clearCache();
		/** @var Category $category */
		$category = $this->model()->find($id);

		if (Article::where(['category_id' => $id])->count()) {
			throw new AccessDeniedHttpException('该分类下有文章,不能删除');
		}

		return $category->destroy($id);
	}
}
