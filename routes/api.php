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
    Route::post('logout', 'UserController@logout');
    Route::post('register', 'UserController@register');

    Route::get('userLanguage', 'UserController@getUserLanguage');
    Route::post('userLanguage', 'UserController@updateUserLanguage');
    Route::get('payment_widget_params', 'PaymentController@payment_widget_params');
    Route::post('pay', 'PaymentController@pay');
    Route::post('paystatus', 'PaymentController@paystatus');
    Route::post('subscribe', 'PaymentController@subscribe');
    Route::post('unsubscribe', 'PaymentController@unsubscribe');
    Route::post('updatesubscribe', 'PaymentController@updatesubscribe');
    Route::post('sendinvoice', 'PaymentController@sendinvoice');
    Route::post('cancelinvoice', 'PaymentController@cancelinvoice');

    Route::post('booking', 'BookingController@BookService');
    Route::post('updateBookingStatus', 'BookingController@updateBookingEnum');

    Route::post('userLocation', 'UserLocationController@store');
    Route::get('userLocation', 'UserLocationController@getUserLocations');
    Route::post('locationDelete', 'UserLocationController@deleteLocation');
    Route::post('locationUpdate', 'UserLocationController@updateLocation');

    Route::post('userUpdate', 'UserController@updateUserInformation');


});

Route::get('sendemail', 'EmailController@sendEMail');

Route::post('sendsms', 'SMSController@sendSMS');
Route::post('verifysmscode', 'SMSController@verifySMSCode');

Route::post('login', 'UserController@login');

Route::get('booking/price', 'BookingController@getQuestionsPrice');

Route::get('service/{id}', 'ServiceController@show');
Route::get('service', 'ServiceController@index');
Route::post('service', 'ServiceController@store');
Route::post('service/{id}', 'ServiceController@update');
Route::get('service/delete/{id}', 'ServiceController@delete');

Route::get('providers', 'ServiceProviderController@getProvidersByServiceType');

Route::get('checkFullName', 'UserController@checkFullName');
Route::get('schedulesDays', 'ScheduleController@getSchedulesDays');
Route::get('schedulesTime', 'ScheduleController@getSchedulesTime');

Route::get('materialPrice', 'ServiceController@getMaterialPrice');
Route::get('hourPrice', 'ServiceController@getHourPrice');
