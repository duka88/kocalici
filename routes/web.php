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

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'admin'])->group(function(){

	
});


Auth::routes();

Route::get('{path}','HomeController@index')->where( 'path', '([A-z\d-/_.]+)?' );




