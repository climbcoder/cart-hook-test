<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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

Route::prefix('v1')
    ->group(function () {
        Route::resource('users', 'V1\UserController');
        Route::get('users/{id}/posts', 'V1\PostController@userPosts');
        Route::get('posts/{id}/comments', 'V1\CommentController@postComments');
    });

Route::prefix('v2')
    ->group(function () {
        Route::resource('users', 'V2\UserController');
        Route::get('users/{id}/posts', 'V2\PostController@userPosts');
    });
