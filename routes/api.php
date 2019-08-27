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




Route::group(['middleware' => 'jwt.auth'], function() {

    Route::post('/get-user', 'AuthController@getUsers');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh-token', 'AuthController@refreshToken');
});


Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
