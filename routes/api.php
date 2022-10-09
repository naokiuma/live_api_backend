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


Route::get('comments','App\Http\Controllers\CommentsController@getAllComments');

Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout');
Route::post('test', 'App\Http\Controllers\Auth\LoginController@test');


