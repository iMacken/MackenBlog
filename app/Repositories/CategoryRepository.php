<?php

namespace App\Repositories;

use App\Category;

/**
 * Class CategoryRepository
 * @package App\Http\Repository
 */
class CategoryRepository
{
	use Repository;
	/**
	 * @return mixed
	 */
	public function getAll()
	{
		return Category::withCount('articles')->get();
	}

}