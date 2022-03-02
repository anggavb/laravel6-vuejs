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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Ambil Semua Data Artikel
Route::get('articles', 'ArticleController@index');

// Membuat Artikel Baru
Route::post('article', 'ArticleController@store');

// Mengambil Satu Artikel (Berdasarkan ID)
Route::get('article/{id}', 'ArticleController@show');

// Mengubah Artikel
Route::put('article/{id}', 'ArticleController@update');

// Menghapus Artikel
Route::delete('article/{id}', 'ArticleController@destroy');
