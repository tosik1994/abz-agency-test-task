<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers\User','prefix' => 'users'], function(){
    Route::get('/create','CreateController')->name('user.create');
    Route::get('/','IndexController')->name('user.index');
    Route::get('/{user}','ShowController')->name('user.show');

});

Route::get('/token','App\Http\Controllers\Token\IndexController')->name('token.index');
Route::get('/positions','App\Http\Controllers\Position\IndexController')->name('position.index');
