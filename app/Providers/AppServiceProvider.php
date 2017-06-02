<?php

namespace App\Providers;

use App\Repositories\MapRepository;
use App\Services\Toastr;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $lang = config('app.locale') != 'zh_cn' ? config('app.locale') : 'zh';
        \Carbon\Carbon::setLocale($lang);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('BlogConfig', function ($app) {
            return new MapRepository();
        });
        $this->app->singleton('Toastr', function ($app) {
            return new Toastr($this->app->make('session'));
        });
    }
}
