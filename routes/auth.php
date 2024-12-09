<?php

use App\Http\Controllers\API\Dashboard\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::get('authenticated', [AuthController::class, 'checkAuthenticated']);
});

Route::middleware('auth')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
});
