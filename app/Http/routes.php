<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('client', 'ClientController@index');
Route::post('client', 'ClientController@store');
Route::get('client/{id}', 'ClientController@show');
Route::delete('client/{id}', 'ClientController@destroy');
Route::put('client/{id}', 'ClientController@update');

Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::get('project/{id}', 'ProjectController@show');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::put('project/{id}', 'ProjectController@update');

Route::group(['prefix' => 'project'], function () {
    Route::get('{id}/tasks', 'ProjectTaskController@index');
    Route::post('{id}/tasks', 'ProjectTaskController@store');
    Route::get('{id}/tasks/{idTask}', 'ProjectTaskController@show');
    Route::delete('{id}/tasks/{idTask}', 'ProjectTaskController@destroy');
    Route::put('{id}/tasks/{idTask}', 'ProjectTaskController@update');
});