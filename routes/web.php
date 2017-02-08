<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::post('password/change', 'UserController@changePassword')->middleware('auth');
Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('auth/github/register', 'Auth\AuthController@create');
Route::post('auth/github/register', 'Auth\AuthController@store');


Route::get('/', 'ArticleController@index');

Route::resource('user','UserController');
Route::resource('category','CategoryController');
Route::resource('tag','TagController');
Route::resource('navigation','NavigationController');
Route::resource('link','LinkController');
Route::get('search/{keyword}', 'SearchController@show');

Route::resource('article', 'ArticleController');
Route::get('page/{page}', 'PageController@show');
Route::get('archive/{year}/{month}', ['as' => 'article-archive-list', 'uses' => 'ArticleController@archive']);