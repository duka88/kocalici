<?php

use  App\Http\Controllers\Single\RecipeController;
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

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/recipes/{recipe}','single\RecipeController@show')->name('recipes.show');    
Route::get('/fridge', 'FridgeController@index')->name('fridge');



Route::middleware(['auth'])->group(function(){

	Route::put('profile','ProfileController@update');
	Route::get('/home', 'HomeController@index')->name('home');
   

    Route::get('notifications', 'ScoreController@notifications');
    Route::get('comments', 'ScoreController@allComments');
    Route::get('new_comments', 'ScoreController@new_comments');
    Route::post('approved', 'ScoreController@approved');    
    Route::post('rating', 'ScoreController@create');
    Route::post('recipe', 'RecipesController@stored');
    Route::post('raply', 'ScoreController@reply');

    Route::get('category', 'CategoriesController@show');
    Route::put('category', 'CategoriesController@update');
    Route::post('category', 'CategoriesController@store');
    Route::delete('category/{id}', 'CategoriesController@destroy');


    Route::get('restore/{id}', 'RecipesController@restore');
    Route::get('trash/{search}/{order}/{direction}', 'RecipesController@trash');
    Route::get('all-recipes/{search}/{order}/{direction}', 'RecipesController@all_recipe');
    Route::delete('recipe/{id}', 'RecipesController@delete');
    Route::put('edit-recipe', 'RecipesController@edit_recipe');
    Route::get('users_recipe/{order}/{direction}/{search}','RecipesController@user_recipe');


    Route::get('comments/{recipe}', 'ScoreController@load');
    Route::get('rating/{recipe}', 'ScoreController@show');


});


Auth::routes();

Route::get('{path}','HomeController@index')->where( 'path', '([A-z\d-/_.]+)?' );



Route::post('newslleter', 'NewsletterController@store');
Route::post('contact_us', 'NewsletterController@contact');
