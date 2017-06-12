<?php

namespace App\Repositories;

use App\Article;
use App\Http\Requests\MenuRequest;
use App\Menu;


class MenuRepository extends Repository
{
	static $tag = 'menu';

	public function tag()
	{
		return MenuRepository::$tag;
	}

	public function model()
	{
		return app(Menu::class);
	}

	public function getAll()
	{
		$categories = $this->remember('menu.all', function () {
			return Menu::withCount('articles')->get();
		});
		return $categories;
	}

	public function get($slug)
	{
		$menu = $this->remember('menu.one.' . $slug, function () use ($slug) {
			return Menu::where('slug', $slug)->first();
		});

		! $menu && abort(404);

		return $menu;
	}

	public function getById($id)
	{
		return $this->model()->findOrFail($id);
	}

	public function create(array $data)
	{
		$this->clearCache();

		$menu = Menu::create($data);

		return $menu;
	}

	public function update(array $data, $id)
	{
		$this->clearCache();

		/** @var Menu $menu */
		$menu = $this->model()->find($id);

		return $menu->update($data);
	}

	public function delete($id)
	{
		$this->clearCache();
		/** @var Menu $menu */
		$menu = $this->model()->find($id);

		return $menu->destroy($id);
	}
}
