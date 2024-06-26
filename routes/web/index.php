<?php

use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/', [PageController::class, 'home']);
});
