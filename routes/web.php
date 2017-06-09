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

//Route::get('/', function () {
//    return view('welcome');
//});

//this is the endpoint of auth
Route::group(['middleware' => \Barryvdh\Cors\HandleCors::class ], function(){
    Route::match(["post", "get"], '/auth/login', 'Auth\AuthController@postLogin'); 
    Route::match(['get', 'post'], '/auth/refresh', 'Auth\AuthController@getRefresh');
    Route::match(['get', 'post'],'/auth/invalidate', 'Auth\AuthController@deleteInvalidate');
});

Route::match(["post", "get"], 'auth/forgotpassword', "api\\v1\PasswordController@forgotPassword");

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
