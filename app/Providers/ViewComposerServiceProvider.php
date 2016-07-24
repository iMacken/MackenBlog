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
            $view->with('navList', \App\Models\Navigation::getNavigationAll());
        });
    }

    /**
     * compose the right column
     * @return [type] [description]
     */
    public function composeRight()
    {
        view()->composer('partials.right', function($view) {
            $view->with('hotArticleList', \App\Models\Article::getHotArticleList(5));
            $view->with('tagList', \App\Models\Tag::getHotTags(12));
            $view->with('archiveList', \App\Models\Article::getArchiveList(12));
            $view->with('linkList', \App\Models\Link::getLinkList());
        });
    }
}
