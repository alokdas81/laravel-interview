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

/*
|--------------------------------------------------------------------------
| Blog routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->resource('categories', 'Api\Blog\CategoryController')->except(['create', 'edit']);
Route::middleware('auth:api')->resource('posts', 'Api\Blog\PostController')->except(['create', 'edit']);
