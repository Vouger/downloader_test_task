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

Route::prefix('downloader')->group(function () {
    Route::get('/', 'DownloaderApi@index');
    Route::get('/{downloader_data}', 'DownloaderApi@show')->name('download_url');
    Route::post('/', 'DownloaderApi@store');
    //Route::put('/{downloader_data}', 'DownloaderApi@update');
    //Route::delete('/{downloader_data}', 'DownloaderApi@delete');
});
