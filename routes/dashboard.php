<?php

use App\Http\Controllers\API\AppAPIController;
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
    Route::get('/apps', [AppAPIController::class, 'getAll']);
    Route::get('/apps/{id}', [AppAPIController::class, 'get']);
    Route::delete('/apps/{id}', [AppController::class, 'delete'])->name('apps.delete');

    Route::get('/apps/new', [AppController::class, 'new'])->name('apps.new');
    Route::post('/apps/new', [AppController::class, 'create']);

    Route::get('/apps/edit/{id}', [AppController::class, 'edit'])->name('apps.edit');
    Route::put('/apps/edit/{id}', [AppController::class, 'update']);

    Route::post('/apps/edit/detectinfo', [DetectInfoController::class, 'create']);
    Route::put('/apps/edit/detectinfo/{id}', [DetectInfoController::class, 'update']);
    Route::delete('/apps/edit/detectinfo/{id}', [DetectInfoController::class, 'delete']);

    Route::post('/apps/edit/installers', [InstallerController::class, 'create']);
    Route::put('/apps/edit/installers/{id}', [InstallerController::class, 'update']);
    Route::delete('/apps/edit/installers/{id}', [InstallerController::class, 'delete']);

    Route::get('/portable-apps', [PortableAppController::class, 'index'])->name('portable_apps');
    Route::get('/portable-apps/new', [PortableAppController::class, 'new'])->name('portable_apps.new');
    Route::get('/portable-apps/edit/{id}', [PortableAppController::class, 'edit'])->name('portable_apps.edit');
});

require __DIR__ . '/auth.php';
