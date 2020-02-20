<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|register
*/

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/recipes/{recipe}','RecipesController@show')->name('recipes.show');    
Route::get('/fridge', 'FridgeController@index')->name('fridge');


Route::middleware(['admin'])->group(function(){

   Route::put('profile','ProfileController@update');
   Route::get('/home', 'HomeController@index')->name('home');
   
  
  

    Route::get('users', 'UsersController@index');
    Route::post('users','UsersController@create');
    Route::put('users/{id}','UsersController@update');
    Route::delete('users/{id}','UsersController@delete');
    Route::get('new_comments', 'ScoreController@new_comments');
   

    Route::put('category', 'CategoriesController@update');
    Route::post('category', 'CategoriesController@store');
    Route::delete('category/{id}', 'CategoriesController@destroy');
   
    Route::post('recipe', 'RecipesController@stored');
    Route::get('restore/{id}', 'RecipesController@restore');
    Route::get('trash/{search}/{order}/{direction}', 'RecipesController@trash');
    Route::get('all-recipes/{search}/{order}/{direction}', 'RecipesController@all_recipe');
    Route::delete('recipe/{id}', 'RecipesController@delete');
    Route::put('edit-recipe', 'RecipesController@edit_recipe');
    Route::get('users_recipe/{order}/{direction}/{search}','RecipesController@user_recipe');

});
Route::middleware(['auth'])->group(function(){

	Route::post('approved', 'ScoreController@approved');
    Route::get('comments', 'ScoreController@allComments');
    Route::get('my_profile', 'ProfileController@user_profile')->name('my_profile');
    Route::get('notifications', 'ScoreController@notifications');
       
    Route::post('rating', 'ScoreController@create');
    
    Route::post('raply', 'ScoreController@reply');
    Route::get('users_comments','ScoreController@users_comments' );


    Route::get('category', 'CategoriesController@show');      
  
   
    Route::get('profile', 'ProfileController@index');
    Route::put('profile','ProfileController@update');

    
    Route::get('rating/{recipe}', 'ScoreController@show');
    Route::post('like', 'LikeController@create');
   

    Route::get('myLike/{recipe}', 'LikeController@single');
    Route::get('my-likes/','LikeController@user_likes');

});

Route::get('comments/{recipe}', 'ScoreController@load');
Auth::routes();

Route::get('{path}','HomeController@index')->where( 'path', '([A-z\d-/_.]+)?' );



Route::post('newslleter', 'NewsletterController@store');
Route::post('contact_us', 'NewsletterController@contact');
