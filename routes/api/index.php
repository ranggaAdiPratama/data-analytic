<?php

use App\Http\Controllers\MicroticController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'laravel'], function () {
    Route::get('/interfaces/{id}', [MicroticController::class, 'interfaceList']);
    Route::get('/interfaces/ethernet/{id}', [MicroticController::class, 'interfaceEthernetList']);

    Route::get('/dns/{id}', [MicroticController::class, 'dns']);
    Route::get('/ip/dhcp-servers/{id}', [MicroticController::class, 'ipDhcpServerList']);
    Route::get('/ip/hotspot/{id}', [MicroticController::class, 'hotspotList']);

    Route::get('/logs', [MicroticController::class, 'logList']);

    Route::get('/top-host-name/{id}', [MicroticController::class, 'topHostName']);
    Route::get('/top-sites/{id}', [MicroticController::class, 'topSites']);

    Route::get('/system/resources/{id}', [MicroticController::class, 'systemResources']);
});
