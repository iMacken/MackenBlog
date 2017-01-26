<?php
namespace App\Repositories;

use App\Repositories\Contracts\Repository;
use App\Tag;

/**
 * Class TagRepository
 * @package App\Http\Repository
 */
class TagRepository extends Repository
{
	public function model() {
		return 'App\Tag';
	}

	public function search($keyword, $num)
	{
		return Tag::where('name', 'like', '%' . $keyword. '%')->paginate($num);
	}
}