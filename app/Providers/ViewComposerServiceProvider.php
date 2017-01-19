<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeNavigation();
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

    /**
     * compose the navigation bar
     * @return [type] [description]
     */
    public function composeNavigation()
    {
        view()->composer('partials.nav', function($view) {
            $view->with('navList', \App\Navigation::getNavigationAll());
        });
    }

    /**
     * compose the right column
     */
    public function composeRight()
    {
        view()->composer('partials.right', function($view) {
//            $view->with('hotArticleList', \App\Article::getHotArticleList(5));
//            $view->with('tagList', \App\Tag::getHotTags(12));
//            $view->with('archiveList', \App\Article::getArchiveList(12));
//            $view->with('linkList', \App\Link::getLinkList());
        });
    }
}
