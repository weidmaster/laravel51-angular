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

Route::post('oauth/access_token', function () {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function () {
    Route::resource('client','ClientController', ['except' => ['create','edit']]);
    Route::resource('project','ProjectController', ['except' => ['create','edit']]);

    Route::group(['prefix' => 'project'], function () {

        Route::get('{id}/tasks', 'ProjectTaskController@index');
        Route::post('{id}/tasks', 'ProjectTaskController@store');
        Route::get('{id}/tasks/{idTask}', 'ProjectTaskController@show');
        Route::delete('{id}/tasks/{idTask}', 'ProjectTaskController@destroy');
        Route::put('{id}/tasks/{idTask}', 'ProjectTaskController@update');

        Route::get('{id}/members', 'ProjectMemberController@index');
        Route::post('{id}/members/{memberId}', 'ProjectMemberController@store');
        Route::delete('{id}/members/{memberId}', 'ProjectMemberController@destroy');

        Route::post('{id}/file','ProjectFileController@store');
        Route::delete('{id}/file/{idFile}','ProjectFileController@destroy');
    });
});