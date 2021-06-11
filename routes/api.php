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
//upload avatar
Route::patch('users/avatar', 'App\Http\Controllers\UsersController@uploadAvatar');


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
//get all posts of category
Route::get('categories/{category_id}/posts', 'App\Http\Controllers\CategoriesController@getPosts');


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
//get post categories
Route::get('posts/{post_id}/categories', 'App\Http\Controllers\PostsController@getCategories');
//get all comments under post
Route::get('posts/{post_id}/comments', 'App\Http\Controllers\PostsController@getAllPostComments');
//comment under post
Route::post('posts/{post_id}/comments', 'App\Http\Controllers\PostsController@commentUnderPost');
//create post like
Route::post('posts/{post_id}/like', 'App\Http\Controllers\LikesController@likePost');
//get post like
Route::get('posts/{post_id}/like', 'App\Http\Controllers\LikesController@getPostLike');
//delete post like
Route::delete('posts/{post_id}/like', 'App\Http\Controllers\LikesController@deletePostLike');


//COMMENTS

//get comment by id
Route::get('comments/{comment_id}', 'App\Http\Controllers\CommentsController@show');
//update comment
Route::patch('comments/{comment_id}', 'App\Http\Controllers\CommentsController@update');
//delete comment
Route::delete('comments/{comment_id}', 'App\Http\Controllers\CommentsController@destroy');
//create comment like
Route::post('comments/{comment_id}/like', 'App\Http\Controllers\LikesController@likeComment');
//get comment like
Route::get('comments/{comment_id}/like', 'App\Http\Controllers\LikesController@getCommentLike');
//delete comment like
Route::delete('comments/{comment_id}/like', 'App\Http\Controllers\LikesController@deleteCommentLike');
