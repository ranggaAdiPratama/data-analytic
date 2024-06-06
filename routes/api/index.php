<?php

use App\Http\Controllers\MicroticController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/interfaces/ethernet', [MicroticController::class, 'interfaceEthernetList']);
Route::get('/interfaces', [MicroticController::class, 'interfaceList']);
Route::get('/interfaces/wireless', [MicroticController::class, 'interfaceWirelessList']);
Route::get('/interfaces/{id}', [MicroticController::class, 'interfaceById']);

Route::get('/ip/addresses', [MicroticController::class, 'ipAddressList']);
Route::get('/ip/dhcp-clients', [MicroticController::class, 'ipDhcpClientList']);
Route::get('/ip/dhcp-servers', [MicroticController::class, 'ipDhcpServerList']);
Route::get('/ip/firewalls', [MicroticController::class, 'ipFirewallsList']);
Route::get('/ip/routes', [MicroticController::class, 'ipRoutesList']);

Route::get('/system/resources', [MicroticController::class, 'systemResources']);
