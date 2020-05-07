<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('details', 'UserController@details');
    Route::post('logout','UserController@logout');
});

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::get('service/{id}', 'ServiceController@show');
Route::get('service', 'ServiceController@index');
Route::post('service', 'ServiceController@store');
Route::post('service/{id}', 'ServiceController@update');
Route::get('service/delete/{id}', 'ServiceController@delete');

