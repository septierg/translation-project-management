<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
Route::post('/reset-password', 'AuthController@resetPassword');


Route::get('/users', 'UserController@index');
Route::get('/users/{id}', 'UserController@show');
Route::put('/users/{id}', 'UserController@update');
Route::delete('/users/{id}', 'UserController@destroy');

Route::post('/attendance/clock-in', 'AttendanceController@clock_in');
Route::post('/attendance/clock-out', 'AttendanceController@clock_out');
Route::get('/attendance/reports/{id}', 'AttendanceController@reports');
Route::get('/attendance/reports', 'AttendanceController@all_reports');


