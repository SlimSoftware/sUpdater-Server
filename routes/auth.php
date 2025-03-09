<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'store']);
Route::get('authenticated', [AuthController::class, 'checkAuthenticated']);


Route::middleware('auth')->group(function() {
    Route::get('user', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'destroy']);
});
