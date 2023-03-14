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
use App\Services\Twitter;

//PAGE
Route::get('/', 'PagesController@home');
Route::get('/about', 'PagesController@about');
Route::get('/contact', 'PagesController@contact');

//TWITTER EXAMPLE FOR API KEY
/*Route::get('/', function(Twitter $twitter){
    dd($twitter);
});*/

//TASK
Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');
Route::patch('/tasks/{task}', 'ProjectTasksController@update');


Auth::routes();

//PROJECT WITH MIDDLEWARE
Route::resource('projects', 'ProjectsController')->middleware('auth');

//HOME OR DASHBOARD WITH MIDDLEWARE
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');






