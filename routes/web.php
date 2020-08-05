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
Route::get('/test', 'HomeController@test')->name('test');
Route::post('searchProv', 'ServiceProviderController@search')->name('searchProv');
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
    Route::get('/addProvider', 'ServiceProviderController@create')->name('addProvider');
    Route::post('/addProvider', 'ServiceProviderController@create')->name('addProvider');
    Route::get('/providerByService', 'ServiceProviderController@providerByService')->name('providerByService');
    Route::get('/providerByService', 'ServiceProviderController@providerByService')->name('providerByService');
    Route::get('/ShowBYservices', 'ServiceProviderController@ShowBYservices')->name('ShowBYservices');
    Route::get('/providerByCompany', 'ServiceProviderController@providerByCompany')->name('providerByCompany');
    Route::get('/ShowBYcompany', 'ServiceProviderController@ShowBYcompany')->name('ShowBYcompany');
    Route::post('/editProvider/{id}', 'ServiceProviderController@edit')->name('editProvider');
    Route::get('/editProvider/{id}', 'ServiceProviderController@edit')->name('editProvider');
    Route::post('/deleteProvider/{id}', 'ServiceProviderController@destroy')->name('deleteProvider');
    Route::get('/changeProvider/{id}', 'ServiceProviderController@changeProvider')->name('changeProvider');
    Route::post('/changeProvider/{id}', 'ServiceProviderController@changeProvider')->name('changeProvider');
    Route::get('/getSchedules/{id}', 'ServiceProviderController@getSchedules')->name('getSchedules');
    Route::post('/deleteSchedules/{id}', 'ServiceProviderController@deleteSchedules')->name('deleteSche');


});

Route::prefix("/Booking")->group(function () {
    Route::get('/', 'BookingController@All')->name('viewAll');
    Route::get('/autoAssignBooking', 'BookingController@showAutoAssign')->name('showAutoAssign');
    Route::get('/upComingBooking', 'BookingController@upComingBooking')->name('upComing');
    Route::get('/pastBooking', 'BookingController@pastBooking')->name('pastBooking');
    Route::get('/viewconfirm', 'BookingController@Confirmed')->name('viewconfirm');
    Route::get('/viewCompleted', 'BookingController@Completed')->name('viewCompleted');
    Route::get('/viewcanceled', 'BookingController@Canceled')->name('viewcanceled');
    Route::get('/viewRescheduled', 'BookingController@Rescheduled')->name('viewRescheduled');
    Route::post('/editcompleted/{id}', 'BookingController@change_to_completed')->name('editcompleted');
    Route::post('/editcanceled/{id}', 'BookingController@change_to_canceled')->name('editcanceled');
    Route::get('/getBooking/{id}', 'BookingController@getBookingById')->name('getBooking');
    Route::post('/changeProvider/{id}', 'BookingController@change_provider')->name('changeProvider');

});

Route::prefix("/user")->group(function () {
    Route::get('/', 'PCUser@index')->name('viewUser');
    Route::get('/addUser', 'PCUser@create')->name('addUser');
    Route::post('/addUser', 'PCUser@create')->name('addUser');
    Route::post('/editUser/{id}', 'PCUser@edit')->name('editUser');
    Route::post('/deleteUser/{id}', 'PCUser@destroy')->name('deleteUser');
});
Route::prefix("/service")->group(function () {
    Route::get('/', 'ServiceController@index')->name('viewService');
    Route::post('/editService/{id}', 'ServiceController@edit')->name('editService');
});

Route::prefix("/schedule")->group(function () {
    Route::get('/', 'ServiceController@index')->name('viewService');
    Route::post('/editService/{id}', 'ServiceController@edit')->name('editService');
    Route::post('/addSchedule', 'ScheduleController@create')->name('addSchedule');
    Route::post('/deleteSchedule', 'ScheduleController@delete')->name('deleteSchedule');
});

Route::get('/clearCache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::post('/test/{id}', 'ScheduleController@create');
//Route::get('/home', 'HomeController@index')->name('home');
