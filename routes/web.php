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

Route::get('/','WelcomeController@index')->name('welcome');
Route::get('/posts/single-post/{post}', 'Posts\PostsController@index')->name('posts.single-post');
Route::get('/blog/categories/{category}', 'WelcomeController@category')->name('blog.category');
Route::get('/blog/tags/{tag}', 'WelcomeController@tag')->name('blog.tag');

Auth::routes();



Route::middleware(['auth'])->group(function(){
	Route::get('/home', 'HomeController@index')->name('home');

	Route::resource('categories', 'CategoriesController');
	Route::get('trashed-categories', 'CategoriesController@trash')->name('trashed-categories.index');
	Route::put('restore-category/{category}', 'CategoriesController@restore')->name('restore-category');


	Route::resource('tags', 'TagsController');
	Route::get('trashed-tags', 'TagsController@trash')->name('trashed-tags.index');
	Route::put('restore-tags/{tag}', 'TagsController@restore')->name('restore-tag');

	Route::resource('posts', 'PostsController');
	Route::get('trashed-posts', 'PostsController@trash')->name('trashed-posts.index');
	Route::put('restore-post/{post}', 'PostsController@restore')->name('restore-post');
});


Route::middleware(['auth', 'admin'])->group(function(){
	Route::get('users', 'UsersController@index')->name('users.index');
	Route::post('users/{user}/make-admin', 'UsersController@makeAdmin')->name('users.make-admin');
	Route::get('users/{user}/show', 'UsersController@show')->name('users.show');
});

Route::get('users/user-profile', 'UsersController@edit')->name('users.edit')->middleware('auth');
Route::put('users/update-profile', 'UsersController@update')->name('users.update')->middleware('auth');