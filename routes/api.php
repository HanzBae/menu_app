<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

Route::middleware('api')->group(function () {
    Route::apiResource('menus', MenuController::class);
    Route::apiResource('orders', OrderController::class);
});