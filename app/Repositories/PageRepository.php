<?php

namespace App\Repositories;

use App\Page;
use App\Services\MarkdownParser;

class PageRepository extends Repository
{
	protected $markdownParser;

	static $tag = 'page';

	/**
	 * PageRepository constructor.
	 * @param MarkdownParser $markdownParser
	 */
	public function __construct(MarkdownParser $markdownParser)
	{
		$this->markdownParser = $markdownParser;
	}

	/**
	 * @return \Illuminate\Foundation\Application|mixed
	 */
	public function model()
	{
		return app(Page::class);
	}

	/**
	 * @return string
	 */
	public function tag()
	{
		return PageRepository::$tag;
	}

	/**
	 * @return mixed
	 */
	public function count()
	{
		$count = $this->remember($this->tag() . '.count', function () {
			return $this->model()->withoutGlobalScopes()->count();
		});
		return $count;
	}

	/**
	 * @param int $limit
	 * @return mixed
	 */
	public function pagedPagesWithoutGlobalScopes($limit = 15)
	{
		$pages = $this->remember('pages.withoutContent.page.' . $limit . '' . request()->get('page', 1), function () use ($limit) {
			return Page::select(['title', 'id', 'created_at'])->withoutGlobalScopes()->withCount('comments')->orderBy('created_at', 'desc')->paginate($limit);
		});
		return $pages;
	}

	/**
	 * @param int $limit
	 * @return mixed
	 */
	public function pagedPages($limit = 10)
	{
		$pages = $this->remember('pages.page.' . $limit . '' . request()->get('page', 1), function () use ($limit) {
			return Page::select(['title', 'id', 'created_at'])->withCount('comments')->orderBy('published_at', 'desc')->paginate($limit);
		});
		return $pages;
	}

	/**
	 * @param $slug string
	 * @return Page
	 */
	public function get($slug)
	{
		$page = $this->remember('page.one.' . $slug, function () use ($slug) {
			return Page::where('slug', $slug)->withCount('comments')->firstOrFail();
		});
		return $page;
	}

	public function getById($id)
	{
		return Page::withCount('comments')->findOrFail($id);
	}

	/**
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data)
	{
		$this->clearCache();

		/** @var Page $page */
		$page = auth()->user()->pages()->create(
			array_merge(
				$data,
				[
					'html_content' => $this->markdownParser->convertMarkdownToHtml($data['content'], false),
				]
			)
		);

		$page->saveConfig($data);

		return $page;
	}

	/**
	 * @param array
	 * @param int $id
	 * @return mixed
	 */
	public function update(array $data, $id)
	{
		$this->clearCache();

		/** @var Page $page */
		$page = $this->model()->find($id);

		$page->saveConfig($data);

		$result = $page->update(
			array_merge($data, [
			    'html_content' => $this->markdownParser->convertMarkdownToHtml($data['content'], false)
            ])
		);

		return $result;
	}
	
	public function delete($id)
	{
		$this->clearCache();
		/** @var Page $page */
		$page = $this->model()->find($id);
		$result = $page->destroy($id);

		$result && $page->delete(); # delete from scout

		return $result;
	}
}
