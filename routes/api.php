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


Route::post('login', 'AuthController@login');
Route::get('users', 'UsersController@index');
Route::post('users','UsersController@create');
Route::put('users/{id}','UsersController@update');
Route::delete('users/{id}','UsersController@delete');
Route::get('profile/{id}', 'ProfileController@index');
Route::put('profile','ProfileController@update');
	



Route::get('recipes/{category_id}', 'RecipesController@category');
Route::get('ingredients/{id}', 'RecipesController@ingredients');
Route::get('users_recipe/{id}','RecipesController@user_recipe');
Route::get('search/{search}/{category}/{order}/{direction}', 'RecipesController@search');



Route::get('fridge', 'FridgeController@apitags');
Route::get('fridged', 'FridgeController@search');



Route::get('comments/{recipe}', 'ScoreController@load');
Route::get('rating/{recipe}/{user}', 'ScoreController@show');
Route::get('users_comments/{id}','ScoreController@users_comments' );



Route::put('update_comment/{id}','ScoreController@update_comment');
Route::delete('comment/{id}', 'ScoreController@delete');


Route::get('gallery/{recipe}', 'GalleryController@index');
Route::get('category', 'CategoriesController@show');

Route::get('searchTag', 'TagsController@search');


Route::post('like', 'LikeController@create');
Route::get('like/{recipe}', 'LikeController@index');
Route::get('myLike/{recipe}/{user}', 'LikeController@single');
Route::get('my-likes/{user}','LikeController@user_likes');




 
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');




