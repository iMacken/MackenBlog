<?php

namespace App\Providers;

use App\Services\BlogCache;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('BlogCache', function ($app) {
            if (config('cache.enable') == 'true') {
                return new BlogCache();
            }
        });
    }
}
