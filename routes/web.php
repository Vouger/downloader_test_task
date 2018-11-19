<?php

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

Route::get('/', 'DownloaderController@index')->name('home');
Route::post('/add', 'DownloaderController@add_url')->name('add_url');
Route::get('/load_table', 'DownloaderController@load_table')->name('load_table');
