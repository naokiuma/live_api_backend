<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

//token発行ルート
Route::get('test',function(){
    $user = Auth::loginUsingId(1);
    $token = $user->createToken('testです');//第二引数に配列で複数のabikities(パーミッション)を指定可能
    //ここで作られたトークンはテーブルに保管される。
    dd($token);
});

Route::middleware('auth:sanctum')->get('/user',function(Request $request){
    return $request->user();
});



Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout');

// Route::post('/login', [LoginController::class, 'login']);

Route::get('/upload/image','App\Http\Controllers\ImageController@input');//画像ファイルアップロードボタン(仮)
Route::post('/upload/image','App\Http\Controllers\ImageController@upload');//画像ファイルアップロード先

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

