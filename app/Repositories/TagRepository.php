<?php

use App\Article;
use App\Tag;
use Illuminate\Http\Request;

/**
 * Class TagRepository
 * @package App\Http\Repository
 */
class TagRepository extends Repository
{

	public function getAll()
	{
		return Tag::withCount('articles')->get();
	}

}