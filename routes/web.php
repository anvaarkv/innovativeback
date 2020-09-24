<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('/', 'HomeController@films')->name('films.index');
    Route::get('/films', 'HomeController@films')->name('films.index');
    Route::get('/create', 'HomeController@create')->name('films.create');
    Route::get('/films/{id?}', 'HomeController@single')->name('films.single');
    Route::get('/countries', 'HomeController@countries')->name('films.countries');
});
//Route::get('dashboard','PostController@index')->name('blog-dashboard');
//Route::get('add-post','PostController@addPost')->name('add-post');
Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
