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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('master/vaksin', 'VaksinController@index');
Route::get('master/vaksin/getdata', 'VaksinController@getdata');
Route::post('master/vaksin', 'VaksinController@store');
Route::get('master/vaksin/getitem/{id}', 'VaksinController@getitem');
Route::delete('master/vaksin', 'VaksinController@destroy');
Route::post('master/vaksin/storefile', 'VaksinController@storefile');