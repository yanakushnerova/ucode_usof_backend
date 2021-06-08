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
//create user if admin
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
