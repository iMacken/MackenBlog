<?php

namespace App\Providers;

use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
	protected $postRepository;
	protected $tagRepository;


	/**
	 * Bootstrap the application services.
	 * @param PostRepository $postRepository
	 * @param TagRepository $tagRepository
	 */
	public function boot(PostRepository $postRepository,
	                     TagRepository $tagRepository)
	{
		$this->tagRepository     = $tagRepository;
		$this->postRepository = $postRepository;

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
//			$view->with('hotPostList', $this->postRepository->hot(5));
//			$view->with('tagList', $this->tagRepository->hot(12));
//			$view->with('archiveList', $this->postRepository->archive(12));
		});
	}
}
