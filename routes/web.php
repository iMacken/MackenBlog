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

Route::get('/', 'ArticleController@index');

Route::get('category/{category}', 'CategoryController@show');
Route::get('tag/{tag}', 'TagController@show');
Route::get('search/{keyword}', 'SearchController@show');

Route::resource('article', 'ArticleController');
Route::get('page/{page}', 'PageController@show');
Route::get('archive/{year}/{month}', ['as' => 'article-archive-list', 'uses' => 'ArticleController@archive']);

Auth::routes();

Route::group(['prefix' => 'backend', 'namespace' => 'Backend', 'middleware' => 'auth'],function(){
    Route::any('/','HomeController@index');
    Route::get('article/createIndex', 'ArticleController@indexAll');
    Route::resource('home', 'HomeController');
    Route::resource('category','CategoryController', ['as' => 'backend']);
    Route::resource('article','ArticleController', ['as' => 'backend']);
    Route::resource('tag','TagController', ['as' => 'backend']);
    Route::get('api/tags', ['uses'=>'TagController@getTags']);
    Route::resource('user','UserController', ['as' => 'backend']);
    Route::resource('navigation','NavigationController', ['as' => 'backend']);
    Route::resource('link','LinkController', ['as' => 'backend']);
    Route::resource('upload', 'UploadController', ['only' => 'store']);
    Route::get('setting', ['uses' => 'SettingController@index', 'as' => 'backend.setting']);
    Route::post('setting', ['uses' => 'SettingController@save', 'as' => 'backend.setting.save']);
});
