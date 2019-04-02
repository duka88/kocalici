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

Auth::routes();

Route::middleware(['auth'])->group(function(){
	Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('/category', 'CategoriesController');
    Route::resource('/tags', 'TagsController');
    Route::resource('/recipe', 'RecipesController');
    Route::get('trashed-recipe', 'RecipesController@trashed')->name('trashed-recipe.index');
    Route::put('restore-recipe/{post}', 'RecipesController@restore')->name('restore-recipe');
});
