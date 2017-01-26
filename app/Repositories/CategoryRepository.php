<?php

namespace App\Repositories;

use App\Repositories\Contracts\Repository;

/**
 * Class CategoryRepository
 */
class CategoryRepository extends Repository
{
	public function model() {
		return 'App\Category';
	}
}