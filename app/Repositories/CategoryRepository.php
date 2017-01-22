<?php

namespace App\Http\Repositories;

use App\Category;
use App\Article;
use Illuminate\Http\Request;

/**
 * Class CategoryRepository
 * @package App\Http\Repository
 */
class CategoryRepository extends Repository
{
	/**
	 * @return mixed
	 */
	public function getAll()
	{
		return Category::withCount('posts')->get();
	}

}