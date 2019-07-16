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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/text', 'Text\TextController@index');
Route::get('/video/look', 'Text\TextController@look');
Route::get('/timeFile', 'Text\TextController@timeFile');
Route::get('/ab', 'Text\TextController@ab');
