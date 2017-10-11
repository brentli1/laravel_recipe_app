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

Route::group(['middleware' => ['auth:api']], function () {
	Route::get('/user', 'UserController@fetchUser');

	Route::get('/recipe/all', 'RecipeController@getRecipes');
	Route::post('/recipe/new', 'RecipeController@new');
	Route::get('/recipe/{id}', 'RecipeController@getRecipe');
	Route::post('/recipe/edit/{id}', 'RecipeController@update');

	Route::get('/categories', 'CategoryController@getCategories');

	Route::post('/steps/new/{id}', 'StepController@create');
});
