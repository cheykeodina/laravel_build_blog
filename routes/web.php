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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::get('/threads/create', 'ThreadsController@create');
Route::post('/threads', 'ThreadsController@store');
Route::get('/threads/{channel}', 'ThreadsController@index');
// User Thread Resource Routes
///Route::resource('threads', 'ThreadsController');

// replies
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');


// Profiles
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
