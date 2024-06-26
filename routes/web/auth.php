<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'    => 'auth'
], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [PageController::class, 'login']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Route::group(['middleware' => 'auth'], function () {
    //     Route::post('/logout', 'AuthController@logout');
    // });
});
