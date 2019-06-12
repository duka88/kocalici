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
Route::get('rating/{recipe}', 'ScoreController@show');
Route::post('gallery', 'GalleryController@store');
Route::get('gallery', 'GalleryController@index');
Route::put('gallery', 'GalleryController@edit');
Route::get('category', 'CategoriesController@show');
Route::post('recipe', 'RecipesController@stored');
Route::get('searchTag', 'TagsController@search');

