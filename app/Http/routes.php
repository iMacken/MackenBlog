<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'ArticleController@index');

Route::get('category/{category}', 'CategoryController@show');
Route::get('tag/{tag}', 'TagController@show');
Route::get('search/{keyword}', 'SearchController@show');

Route::resource('article', 'ArticleController');
Route::get('page/{page}', 'PageController@show');
Route::get('archive/{year}/{month}', ['as' => 'article-archive-list', 'uses' => 'ArticleController@archive']);

Route::controllers([
    'backend/auth' => 'Backend\AuthController',
    'backend/password' => 'Backend\PasswordController'
]);

Route::group(['prefix'=>'backend', 'namespace'=>'Backend', 'middleware'=>'auth'],function(){
    Route::any('/','HomeController@index');
    Route::get('article/createIndex', 'ArticleController@indexAll');
    Route::resource('home', 'HomeController');
    Route::resource('category','CategoryController');
    Route::resource('article','ArticleController');
    Route::resource('tag','TagController');
    Route::get('api/tags', ['uses'=>'TagController@getTags']);
    Route::resource('user','UserController');
    Route::resource('navigation','NavigationController');
    Route::resource('link','LinkController');
    Route::resource('upload', 'UploadController', ['only' => 'store']);
    Route::controllers([
        'setting'=>'SettingController',
    ]);
});
