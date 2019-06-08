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
    return view('layouts.app');
});

// Auth::routes();

Route::group(['namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::resource('/admin/user', 'UserController');
    Route::resource('/admin/media', 'MediaController');
    Route::get('admin/report/media', 'MediaController@getReport')->name('media.report');

    Route::post('ajax/media/change-status', 'MediaController@changeStatus');
    Route::post('ajax/user/change-status', 'UserController@changeStatus');
    Route::post('ajax/user/change-role', 'UserController@changeRole');
});

Route::get('/admin-home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});
