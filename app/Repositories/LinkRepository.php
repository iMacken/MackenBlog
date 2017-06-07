<?php
namespace App\Repositories;

use App\Link;


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

    public function getById($id)
    {
        return $this->model()->findOrFail($id);
    }

	public function getAll()
	{
		$links = $this->remember('link.all', function () {
			return Link::get();
		});
		return $links;
	}
	
	public function create(array $data)
	{
		$this->clearCache();

		$link = Link::create($data);

		return $link;
	}

    public function update(array $data, $id)
    {
        $this->clearCache();

        /** @var Link $link */
        $link = $this->model()->find($id);

        return $link->update($data);
    }

    public function delete($id)
    {
        $this->clearCache();

        return Link::destroy($id);
    }
}