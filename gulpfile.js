const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    mix.sass('app.scss')

    mix.styles([
    	'plugins/bootstrap/themes/bootstrap-paper.min.css',
    	'plugins/font-awesome/css/font-awesome.min.css',
    	'plugins/social-share.js/css/share.min.css',
    	'plugins/primer-markdown/build/build.css',
    	'plugins/prism/prism.css',
        'plugins/nprogress/nprogress.css',
    	'css/app.css',
    	], null, 'public')

    mix.scripts([
    	'plugins/bootstrap/js/bootstrap.min.js',
    	'plugins/social-share.js/js/jquery.share.min.js',
    	'plugins/geopattern/js/geopattern.min.js',
    	'plugins/prism/prism.js',
        'plugins/pjax/jquery.pjax.js',
        'plugins/nprogress/nprogress.js',
    	'plugins/scripts.js'
    	], null, 'public')

	mix.webpack('app.js')
});
