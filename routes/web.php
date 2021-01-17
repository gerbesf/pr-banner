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


Route::get('/','\App\Http\Controllers\BannerController@proxy');
Route::get('/banner_base','\App\Http\Controllers\BannerController@index');

Route::get('/login','\App\Http\Controllers\AdminController@login');
Route::post('/auth','\App\Http\Controllers\AdminController@auth');
Route::get('/logout','\App\Http\Controllers\AdminController@logout');

Route::group([
    'middleware'=>['admin'],
    'prefix' => 'admin',
    'namespace'=>'\App\Http\Controllers'
],function(){
    Route::get('/','AdminController@admin');
    Route::get('/configure','AdminController@configure');
});
