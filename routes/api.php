<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//USERS

//get all
Route::get('users', 'App\Http\Controllers\UsersController@index');
//store all
Route::post('users', 'App\Http\Controllers\UsersController@store');
//find by id
Route::get('users/{user_id}', 'App\Http\Controllers\UsersController@show');
//update users data
Route::patch('users/{user_id}', 'App\Http\Controllers\UsersController@update');
//delete user
Route::delete('users/{user_id}', 'App\Http\Controllers\UsersController@destroy');


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

//CATEGORIES
