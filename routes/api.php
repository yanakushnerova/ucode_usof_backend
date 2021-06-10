<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

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

//AUTHENTICATION

//login user
Route::post('auth/login', 'App\Http\Controllers\AuthController@login');
//register user
Route::post('auth/register', 'App\Http\Controllers\AuthController@registration');
//logout user
Route::post('auth/logout', 'App\Http\Controllers\AuthController@logout');


//USERS

//get all
Route::get('users', 'App\Http\Controllers\UsersController@index');
//create user FOR ADMIN
Route::post('users', 'App\Http\Controllers\UsersController@store');
//find by id
Route::get('users/{user_id}', 'App\Http\Controllers\UsersController@show');
//update users data
Route::patch('users/{user_id}', 'App\Http\Controllers\UsersController@update');
//delete user FOR ADMIN
Route::delete('users/{user_id}', 'App\Http\Controllers\UsersController@destroy');


//CATEGORIES

//get all
Route::get('categories', 'App\Http\Controllers\CategoriesController@index');
//find by id
Route::get('categories/{category_id}', 'App\Http\Controllers\CategoriesController@show');
//create category FOR ADMIN
Route::post('categories', 'App\Http\Controllers\CategoriesController@store');
//delete category FOR ADMIN
Route::delete('categories/{category_id}', 'App\Http\Controllers\CategoriesController@destroy');
//update FOR ADMIN
Route::patch('categories/{category_id}', 'App\Http\Controllers\CategoriesController@update');


//POSTS

//get all
Route::get('posts', 'App\Http\Controllers\PostsController@index');
//create post
Route::post('posts', 'App\Http\Controllers\PostsController@store');
//find by id
Route::get('posts/{post_id}', 'App\Http\Controllers\PostsController@show');
//update post
Route::patch('posts/{post_id}', 'App\Http\Controllers\PostsController@update');
//delete post
Route::delete('posts/{post_id}', 'App\Http\Controllers\PostsController@destroy');
