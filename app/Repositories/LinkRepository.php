<?php
namespace App\Repositories;

use App\Http\Requests\LinkRequest;
use App\Link;

/**
 * Class LinkRepository
 * @package App\Http\Repository
 */
class LinkRepository extends Repository
{
	static $tag = 'link';

	public function tag()
	{
		return LinkRepository::$tag;
	}

	public function model()
	{
		return app(Link::class);
	}

	public function getAll()
	{
		$links = $this->remember('link.all', function () {
			return Link::get();
		});
		return $links;
	}
	
	public function create(LinkRequest $request)
	{
		$this->clearCache();

		$link = Link::create($request->all());
		return $link;
	}

	public function update(LinkRequest $request)
	{
		$this->clearCache();

		$result = Link::update($request->all);
		return $result;
	}
}