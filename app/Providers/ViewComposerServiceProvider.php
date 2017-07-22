<?php

namespace App\Providers;

use App\Repositories\ArticleRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
	protected $articleRepository;
	protected $tagRepository;


	/**
	 * Bootstrap the application services.
	 * @param ArticleRepository $articleRepository
	 * @param TagRepository $tagRepository
	 */
	public function boot(ArticleRepository $articleRepository,
	                     TagRepository $tagRepository)
	{
		$this->tagRepository     = $tagRepository;
		$this->articleRepository = $articleRepository;

		$this->composeGlobal();
		$this->composeRight();
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
		view()->composer('app', function ($view) {
		    /** @var \Illuminate\View\View $view */
//            $view->with(BlogConfig::getArrayByTag('setting'));
		});
	}

	public function composeRight()
	{
		view()->composer('partials.right', function ($view) {
            /** @var \Illuminate\View\View $view */
//			$view->with('hotArticleList', $this->articleRepository->hot(5));
//			$view->with('tagList', $this->tagRepository->hot(12));
//			$view->with('archiveList', $this->articleRepository->archive(12));
		});
	}
}
