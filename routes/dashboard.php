<?php

use App\Http\Controllers\API\AppAPIController;
use App\Http\Controllers\API\PortableAppAPIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "dashboard" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth')->group(function() {
    Route::get('/apps', [AppAPIController::class, 'getAll']);
    Route::get('/apps/{id}', [AppAPIController::class, 'get']);
    Route::get('/portable-apps', [PortableAppAPIController::class, 'getAll']);
    Route::get('/portable-apps/{id}', [PortableAppAPIController::class, 'get']);
});

require __DIR__ . '/auth.php';
