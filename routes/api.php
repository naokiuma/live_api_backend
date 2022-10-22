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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get('comments', 'CommentsController@getAllComments');//7以前の書き方
//Route::get('comments', [CommentsController::class, 'getAllComments']);//8以降の書き方


// Route::get('comments','App\Http\Controllers\CommentsController@getComments');
Route::get('comments/{topic_id?}','App\Http\Controllers\CommentsController@getComments');


Route::get('topics','App\Http\Controllers\TopicsController@getTopics');



Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout');
Route::post('test', 'App\Http\Controllers\Auth\LoginController@test');


