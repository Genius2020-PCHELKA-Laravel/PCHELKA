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

Route::get('/', 'CompanyController@index')->name('viewCompany');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
//
//Route::get('/admin',function(){
//    return view('admin.register');
//});
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::prefix("/company")->group(function () {
    Route::get('/', 'CompanyController@index')->name('viewCompany');
    Route::get('/addCompany', 'CompanyController@create')->name('addCompany');
    Route::post('/addCompany', 'CompanyController@create')->name('addCompany');
    Route::post('/editCompany/{id}', 'CompanyController@edit')->name('editCompany');
    Route::post('/deleteCompany/{id}', 'CompanyController@destroy')->name('deleteCompany');
});
Route::prefix("/provider")->group(function () {
    Route::get('/', 'ServiceProviderController@index')->name('viewProvider');
    Route::get('/addCompany', 'CompanyController@create')->name('addCompany');
    Route::post('/addCompany', 'CompanyController@create')->name('addCompany');
    Route::post('/editCompany/{id}', 'CompanyController@edit')->name('editCompany');
    Route::post('/deleteCompany/{id}', 'CompanyController@destroy')->name('deleteCompany');
});
Route::get('/clearCache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});


//Route::get('/home', 'HomeController@index')->name('home');
