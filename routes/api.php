<?php

use App\Http\Controllers\API\AppAPIController;
use App\Http\Controllers\API\LegacyAPIController;
use App\Http\Controllers\API\PortableAppAPIController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API v2
Route::get('/v2/apps/', [AppAPIController::class, 'getAll']);
Route::get('/v2/apps/category/{slug}', [AppAPIController::class, 'getCategory']);
Route::get('/v2/apps/category/{id:[0-9]+}', [AppAPIController::class, 'getCategory']);
Route::get('/v2/portable-apps/', [PortableAppAPIController::class, 'getAll']);
Route::get('/v2/portable-apps/category/{id:[0-9]+}', [PortableAppAPIController::class, 'getCategory']);
Route::get('/v2/portable-apps/category/{slug}', [PortableAppAPIController::class, 'getCategory']);
Route::get('/v2/portable-apps/{id}', [PortableAppAPIController::class, 'get']);

// API v1
Route::get('/apps', [LegacyAPIController::class, 'apps_v1']);
Route::get('/apps/category/{categoryId:[0-9]+}', [LegacyAPIController::class, 'apps_v1']);
Route::get('/apps/category/{categorySlug}', [LegacyAPIController::class, 'apps_v1']);
Route::get('/changelog', [LegacyAPIController::class, 'changelog']);
Route::get('/website', [LegacyAPIController::class, 'website']);
