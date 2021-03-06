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

Route::group([
    // Prefixed with /auth
    'prefix' => 'auth',
], function() {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::get('register/activate/{token}', 'AuthController@activate');

    // Requires Authorization: Bearer <access_token>
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('getUser', 'AuthController@getUser');
        Route::post('password/change', 'AuthController@changePassword');
    });

    // Limit number of requests per seconds, configured in app/Http/Kernel.php
    Route::group([
        'middleware' => 'api',
    ], function () {
        Route::post('password/token/create', 'AuthController@createPasswordResetToken');
        Route::get('password/token/find/{token}', 'AuthController@findPasswordResetToken');
        Route::post('password/reset', 'AuthController@resetPassword');
    });
});
