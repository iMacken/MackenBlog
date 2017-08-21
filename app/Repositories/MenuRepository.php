<?php

namespace App\Repositories;

use App\Models\Menu;

class MenuRepository
{
	public function getAll()
	{
		$categories = $this->remember('menu.all', function () {
			return Menu::withCount('posts as posts_count')->get();
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
