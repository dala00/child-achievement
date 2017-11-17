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


Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::put('/home/toggle', 'HomeController@toggle');
Route::patch('/home/toggle', 'HomeController@toggle');
Route::get('/home/summary', 'HomeController@summary')->name('summary');

Route::get('/auth/callback', 'Auth\LoginController@callback');
Route::get('/logout', 'Auth\LoginController@logout');
