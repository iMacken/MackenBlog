<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Category;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


class CategoryRepository
{
    use BaseRepositoryTrait, PaginateRepositoryTrait;

    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

	public function update(array $data, $id)
	{
		/** @var Category $category */
		$category = $this->find($id);

		return $category->update($data);
	}

	public function delete($id)
	{
		/** @var Category $category */
		$category = $this->find($id);

		if (Article::query()->where('category_id', $id)->count()) {
			throw new AccessDeniedHttpException('该分类下有文章,不能删除');
		}

		return $category->destroy($id);
	}
}
