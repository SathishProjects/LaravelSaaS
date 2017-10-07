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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/createdb', 'HomeController@createDatabase')->name('createdb');

Route::group(['middleware' => ['tenant']], function () {

    Route::get('/migrate', 'HomeController@migrateDatabase')->name('migratedb');
});

Route::group(['middleware' => ['web']], function () {

    Route::get('admin/login', 'Auth\AdminLoginController@getAdminLogin')->name('admin.login');
    Route::post('admin/login', ['as'=>'admin.auth','uses'=>'Auth\AdminLoginController@adminAuth']);
    Route::post('admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    Route::group(['middleware' => ['admin']], function () {
    	Route::get('admin/dashboard', ['as'=>'admin.dashboard','uses'=>'Admin\HomeController@dashboard']);
    });

});