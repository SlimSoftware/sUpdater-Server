<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\PortableAppController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/v2/apps', [AppController::class, 'getAll']);
Route::get('/v2/apps/{id}', [AppController::class, 'get']);

Route::get('/v2/portable-apps', [PortableAppController::class, 'getAll']);
Route::get('/v2/portable-apps/{id}', [PortableAppController::class, 'get']);
