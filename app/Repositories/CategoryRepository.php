<?php

namespace App\Repositories;

use App\Http\Requests\CategoryRequest;
use App\Category;

/**
 * Class CategoryRepository
 */
class CategoryRepository extends Repository
{
	static $tag = 'category';

	/**
	 * @return string
	 */
	public function tag()
	{
		return CategoryRepository::$tag;
	}

	/**
	 * @return \Illuminate\Foundation\Application|mixed
	 */
	public function model()
	{
		return app(Category::class);
	}

	/**
	 * @return mixed
	 */
	public function getAll()
	{
		$categories = $this->remember('category.all', function () {
			return Category::withCount('articles')->get();
		});
		return $categories;
	}

	/**
	 * @param $name
	 * @return mixed
	 */
	public function get($name)
	{
		$category = $this->remember('category.one.' . $name, function () use ($name) {
			return Category::where('name', $name)->first();
		});

		!$category && abort(404);

		return $category;
	}

	/**
	 * @param Category $category
	 * @param int $limit
	 * @return mixed
	 */
	public function pagedArticlesByCategory(Category $category, $limit = 7)
	{
		$cacheKey = 'articles.category.' . $category->name . '.page.' . $limit . request()->get('page', 1);
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

	/**
	 * @param CategoryRequest $request
	 * @return Category
	 */
	public function create(CategoryRequest $request)
	{
		$this->clearCache();

		$category = Category::create(['name' => $request['name']]);

		return $category;
	}

	/**
	 * @param Request $request
	 * @param Category $category
	 * @return bool|int
	 */
	public function update(Request $request, Category $category)
	{
		$this->clearCache();
		return $category->update($request->all());
	}
}