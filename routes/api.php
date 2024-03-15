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
/*Route::resources([
        '/users' => 'PhotoController',
        'posts' => 'PostController'
]);
Route::controller('UsersController')->group(function(){
    Route::get('/users', 'index');

});

 public function index(){
        $users = User::all();

        return response()->json(['data' => $users], 200);

    }

*/

