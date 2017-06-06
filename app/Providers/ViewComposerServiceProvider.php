<?php

namespace App\Providers;

use App\Facades\BlogConfig;
use App\Navigation;
use App\Repositories\ArticleRepository;
use App\Repositories\LinkRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
	protected $articleRepository;
	protected $tagRepository;
	protected $linkRepository;


	/**
	 * Bootstrap the application services.
	 * @param ArticleRepository $articleRepository
	 * @param TagRepository $tagRepository
	 * @param LinkRepository $linkRepository
	 */
	public function boot(ArticleRepository $articleRepository,
	                     TagRepository $tagRepository,
	                     LinkRepository $linkRepository)
	{
		$this->tagRepository     = $tagRepository;
		$this->articleRepository = $articleRepository;
		$this->linkRepository    = $linkRepository;

		$this->composeGlobal();
		$this->composeNavigation();
		$this->composeRight($articleRepository, $tagRepository, $linkRepository);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	public function composeGlobal()
	{
		view()->composer('*', function ($view) {
		    /** @var \Illuminate\View\View $view */
            $view->with(BlogConfig::getArrayByTag('setting'));
		});
	}

	public function composeNavigation()
	{
		view()->composer('partials.nav', function ($view) {
            /** @var \Illuminate\View\View $view */
			$view->with('navList', Navigation::getNavigationAll());
		});
	}

	public function composeRight()
	{
		view()->composer('partials.right', function ($view) {
            /** @var \Illuminate\View\View $view */
			$view->with('hotArticleList', $this->articleRepository->hot(5));
			$view->with('tagList', $this->tagRepository->hot(12));
			$view->with('archiveList', $this->articleRepository->archive(12));
			$view->with('linkList', $this->linkRepository->getAll());
		});
	}
}
