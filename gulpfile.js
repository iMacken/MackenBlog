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

    mix.styles([
    	'../public/css/app.css',
    	'prismjs/themes/prism-coy.css'
    	], null, 'node_modules');

    mix.scripts([
    	'bootstrap-sass/assets/javascripts/bootstrap.min.js',
    	'social-share.js/dist/js/jquery.share.min.js',
    	'prismjs/prism.js'
    	], null, 'node_modules');
});
