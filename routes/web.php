<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('sample/{id?}', 'App\Http\Controllers\SampleController@index');
//Route::get('sample', 'SampleController@index');//この書き方じゃダメwになったよ

//画像ファイルアップロードボタン(仮)
Route::get('/upload/image','App\Http\Controllers\ImageController@input');
//画像ファイルアップロード先
Route::post('/upload/image','App\Http\Controllers\ImageController@upload');

