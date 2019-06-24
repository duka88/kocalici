<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('recipes/{category_id}', 'RecipesController@category');

Route::get('fridge', 'FridgeController@apitags');
Route::get('fridged', 'FridgeController@search');


Route::post('rating', 'ScoreController@create');
Route::get('comments/{recipe}', 'ScoreController@load');
Route::get('rating/{recipe}/{user}', 'ScoreController@show');


Route::get('gallery/{recipe}', 'GalleryController@index');
Route::get('category', 'CategoriesController@show');
Route::post('recipe', 'RecipesController@stored');
Route::get('searchTag', 'TagsController@search');


Route::post('like', 'LikeController@create');
Route::get('like/{recipe}', 'LikeController@index');
Route::get('myLike/{recipe}/{user}', 'LikeController@single');


Route::get('users', 'UsersController@index');
Route::post('users','UsersController@create');
Route::put('users/{id}','UsersController@update');
Route::delete('users/{id}','UsersController@delete');
Route::post('/login', 'AuthController@login');
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');
Route::get('profile', 'ProfileController@index');
