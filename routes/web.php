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

Auth::routes();

Route::group(['middleware' => 'auth'], function()
{
});

Route::get('/', 'HomeController@index');

Route::get('/feed', 'HomeController@feed');

Route::get('/blog', 'HomeController@blog');

Route::get('/about', 'HomeController@blog');

Route::get('/contact', 'HomeController@blog');

