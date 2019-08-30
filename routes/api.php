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



	



Route::get('recipes/{category_id}/{order}/{direction}', 'RecipesController@category');
Route::get('ingredients/{id}', 'RecipesController@ingredients');

Route::get('search/{search}/{category}/{order}/{direction}', 'RecipesController@search');
Route::get('recipe/{id}', 'RecipesController@single');



Route::get('fridge', 'FridgeController@apitags');
Route::get('fridged', 'FridgeController@search');








Route::put('update_comment/{id}','ScoreController@update_comment');
Route::delete('comment/{id}', 'ScoreController@delete');


Route::get('gallery/{recipe}', 'GalleryController@index');
Route::get('category', 'CategoriesController@show');

Route::get('searchTag', 'TagsController@search');



Route::get('like/{recipe}', 'LikeController@index');




 





