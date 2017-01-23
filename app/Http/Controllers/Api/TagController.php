<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TagRepository;

class TagController extends Controller
{
	protected $tagRepository;

	public function __construct(TagRepository $tagRepository) {
		$this->tagRepository = $tagRepository;
	}
	public function search(Request $request)
	{
		$keyword = $request->input('keyword');
		return Tag::where('name', 'like', '%' . $keyword. '%')->paginate(10);
	}
}
