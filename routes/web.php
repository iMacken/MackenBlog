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

Route::get('category/{category}', 'CategoryController@show');
Route::get('tag/{tag}', 'TagController@show');
Route::get('search/{keyword}', 'SearchController@show');

Route::resource('article', 'ArticleController');
Route::get('page/{page}', 'PageController@show');
Route::get('archive/{year}/{month}', ['as' => 'article-archive-list', 'uses' => 'ArticleController@archive']);


//Route::group(['prefix' => 'admin', 'middleware' => 'auth'],function(){
//    Route::any('/','DashboardController@index');
//    Route::get('article/createIndex', 'ArticleController@indexAll');
//    Route::resource('category','CategoryController', ['as' => 'admin']);
//    Route::resource('article','ArticleController', ['as' => 'admin']);
//    Route::resource('tag','TagController', ['as' => 'admin']);
//    Route::get('api/tags', ['uses'=>'TagController@getTags']);
//    Route::resource('user','UserController', ['as' => 'admin']);
//    Route::resource('navigation','NavigationController', ['as' => 'admin']);
//    Route::resource('link','LinkController', ['as' => 'admin']);
//    Route::resource('upload', 'UploadController', ['only' => 'store']);
//    Route::get('setting', ['uses' => 'SettingController@index', 'as' => 'admin.setting']);
//    Route::post('setting', ['uses' => 'SettingController@save', 'as' => 'admin.setting.save']);
//});
