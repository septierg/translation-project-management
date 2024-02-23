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
});

Route::middleware('auth:api')->group(function (Request $request) {
    return 'api';
    return $request->user();
});
Route::middleware('auth:api')->get('/auth', function () {
    return 'Hello World';
});
Route::post('/register', function () {
    return 'Hello World';
});

Route::post('/register', function (Request $request) {
    return $request->all();
    //return 'register in api';
});
Route::post('/register', [AuthController::class, 'register']);*/
Route::post('/register', 'AuthController@register');
/*Route::controller(AuthController::class)->group(function(){
    Route::post('/register', 'register');
});*/
