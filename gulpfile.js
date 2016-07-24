var elixir = require('laravel-elixir');

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

    mix.sass('app.scss');

    mix.scripts([
    	'bootstrap-sass/assets/javascripts/bootstrap.min.js',
    	'social-share.js/dist/js/jquery.share.min.js'
    	], null, 'node_modules');
});
