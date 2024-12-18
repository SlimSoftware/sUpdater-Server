<?php

use App\Http\Controllers\API\Dashboard\AuthAPIController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthAPIController::class, 'store']);
Route::get('authenticated', [AuthAPIController::class, 'checkAuthenticated']);


Route::middleware('auth')->group(function() {
    Route::get('user', [AuthAPIController::class, 'getUser']);
    Route::post('logout', [AuthAPIController::class, 'destroy']);
});
