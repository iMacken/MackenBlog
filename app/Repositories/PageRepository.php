<?php

namespace App\Repositories;

use App\Page;
use App\Scopes\PublishedScope;
use App\Services\MarkdownParser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

	public function count()
	{
		$count = $this->remember($this->tag() . '.count', function () {
			return $this->model()->withoutGlobalScopes([PublishedScope::class])->count();
		});

		return $count;
	}

    public function getAll()
    {
        $isAdmin = isAdmin();
        $cacheKey = $isAdmin ? 'page.admin.all' : 'page.all';
        $pages = $this->remember($cacheKey, function () use ($isAdmin) {
            if ($isAdmin) {
                return Page::withoutGlobalScopes([PublishedScope::class])->withCount('comments')->get();
            } else {
                return Page::withCount('comments')->get();
            }
        });

        return $pages;
    }

	public function get($slug)
	{
		$page = $this->remember('page.one.' . $slug, function () use ($slug) {
			return Page::where('slug', $slug)->withCount('comments')->firstOrFail();
		});

		$page = $this->incrementViewCount($page, $slug);

		return $page;
	}

	public function getById($id)
	{
		return Page::withoutGlobalScopes([PublishedScope::class])->withCount('comments')->findOrFail($id);
	}

	public function create(array $data)
	{
		$this->clearCache();

		/** @var Page $page */
		$page = Page::create(
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

	public function update(array $data, $id)
	{
		$this->clearCache();

		/** @var Page $page */
		$page = $this->getById($id);

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

        return Page::destroy($id);
    }

    private function incrementViewCount(Page $page, $slug)
    {
        $viewCountKey = 'page.' . $slug . 'viewCount';
        if (Cache::has($viewCountKey)) {
            $page->view_count = Cache::get($viewCountKey) + 1;
            Cache::put($viewCountKey, $page->view_count, $this->cacheTime());
        } else {
            $page->view_count  = $page->view_count + 1;
            Cache::add($viewCountKey, $page->view_count, $this->cacheTime());
        }
        DB::table('pages')->where('id', $page->id)->increment('view_count');

        return $page;
	}
}
