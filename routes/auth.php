<?php

use App\Http\Controllers\API\Dashboard\AuthAPIController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('login', [AuthAPIController::class, 'login']);
    Route::get('authenticated', [AuthAPIController::class, 'checkAuthenticated']);
});

Route::middleware('auth')->group(function() {
    Route::post('logout', [AuthAPIController::class, 'logout']);
});
