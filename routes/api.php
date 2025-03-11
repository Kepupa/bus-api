<?php

use App\Http\Controllers\RouteController;
use App\Http\Controllers\RouteSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/routes/find-bus', [RouteSearchController::class, 'search']);

Route::put('/routes/{id}', [RouteController::class, 'update']);

