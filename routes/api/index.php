<?php

use App\Http\Controllers\MicroticController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/interfaces/{id}', [MicroticController::class, 'interfaceList']);
Route::get('/interfaces/ethernet/{id}', [MicroticController::class, 'interfaceEthernetList']);

Route::get('/ip/addresses', [MicroticController::class, 'ipAddressList']);
Route::get('/ip/dhcp-servers', [MicroticController::class, 'ipDhcpServerList']);
Route::get('/ip/routes', [MicroticController::class, 'ipRoutesList']);
Route::get('/ip/kid-control', [MicroticController::class, 'ipKidControlList']);

Route::get('/logs', [MicroticController::class, 'logList']);

Route::get('/top-host-name/{id}', [MicroticController::class, 'topHostName']);

Route::get('/system/resources', [MicroticController::class, 'systemResources']);
