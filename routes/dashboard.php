<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\DetectInfoController;
use App\Http\Controllers\InstallerController;
use App\Http\Controllers\PortableAppController;
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
    Route::get('/apps', [AppController::class, 'getAll']);
    Route::get('/apps/{id}', [AppController::class, 'get']);
    Route::delete('/apps/{id}', [AppController::class, 'delete']);

    Route::post('/apps', [AppController::class, 'create']);
    Route::put('/apps/{id}', [AppController::class, 'update']);

    Route::post('/apps/detectinfo', [DetectInfoController::class, 'create']);
    Route::put('/apps/detectinfo/{id}', [DetectInfoController::class, 'update']);
    Route::delete('/apps/detectinfo/{id}', [DetectInfoController::class, 'delete']);

    Route::post('/apps/installers', [InstallerController::class, 'create']);
    Route::put('/apps/installers/{id}', [InstallerController::class, 'update']);
    Route::delete('/apps/installers/{id}', [InstallerController::class, 'delete']);

    Route::get('/portable-apps', [PortableAppController::class, 'getAll']);
    Route::get('/portable-apps/{id}', [PortableAppController::class, 'get']);
    Route::post('/portable-apps', [PortableAppController::class, 'create']);
    Route::put('/portable-apps/{id}', [PortableAppController::class, 'update']);
});

require __DIR__ . '/auth.php';
