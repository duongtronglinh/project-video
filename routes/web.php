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

Route::group(['middleware' => 'locale'], function() {
    Route::get('multi-language/{language}', ['as' => 'multi-language', 'uses' => 'PageController@changeLanguage']);
});

Route::get('/', ['as'=> 'trang-chu', 'uses' => 'FolderController@index']);
Route::post('login', ['as' => 'dang-nhap', 'uses' => 'PageController@login']);

Route::group(['middleware' => 'checkLogin'], function(){
    Route::get('logout', ['as' => 'dang-xuat', 'uses' => 'PageController@logout']);
    Route::resource('folder', 'FolderController');
    Route::resource('video', 'VideoController');
    Route::post('video/delete', 'VideoController@delete');
    Route::get('download/{id}', ['as' => 'download', 'uses' => 'PageController@download']);
    // Route::post('video/download', 'PageController@downloadAll');
});

Route::group(['middleware' => 'checkAdmin'], function(){
    Route::resource('user', 'UserController');
    Route::post('folder/delete', 'FolderController@delete');
    Route::post('permission', 'AdminController@permission');
});
