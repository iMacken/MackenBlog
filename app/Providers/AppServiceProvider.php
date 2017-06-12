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

        $this->loadHelpers();
        $this->registerFormFields();
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    protected function registerFormFields()
    {
        $formFields = [
            'checkbox',
            'date',
            'file',
            'image',
            'multiple_images',
            'number',
            'password',
            'radio_btn',
            'rich_text_box',
            'select_dropdown',
            'select_multiple',
            'text',
            'text_area',
            'timestamp',
            'hidden',
            'code_editor',
        ];

        foreach ($formFields as $formField) {
            $class = studly_case("{$formField}_handler");

            AdminFacade::addFormField("App\\FormFields\\{$class}");
        }

        AdminFacade::addAfterFormField(DescriptionHandler::class);

        event('macken.form-fields.registered');
    }
}
