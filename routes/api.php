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
*/
Route::post('signin', 'AuthController@signin');
Route::post('signup', 'AuthController@signup');
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');
    Route::apiResource('team', 'API\TeamController');
    Route::apiResource('activity', 'API\ActivityController');
});