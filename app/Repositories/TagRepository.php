<?php
namespace App\Repositories;

use App\Tag;

/**
 * Class TagRepository
 * @package App\Http\Repository
 */
class TagRepository
{
	use Repository;

	public function getAll()
	{
		return Tag::withCount('articles')->get();
	}

}