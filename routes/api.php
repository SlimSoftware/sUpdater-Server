<?php

use App\Http\Controllers\API\AppAPIController;
use App\Http\Controllers\API\LegacyAPIController;
use App\Http\Controllers\API\PortableAppAPIController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// API v2
Route::controller(AppAPIController::class)->group(function () {
    Route::get('/v2/apps', 'getAll');
    Route::get('/v2/apps/category/{id}', 'getCategoryById');
    Route::get('/v2/apps/category/{slug}', 'getCategoryBySlug');
    Route::get('/v2/apps/{id}', 'get');
});

Route::controller(PortableAppAPIController::class)->group(function () {
    Route::get('/v2/portable-apps', 'getAll');
    Route::get('/v2/portable-apps/category/{id}', 'getCategoryById');
    Route::get('/v2/portable-apps/category/{slug}', 'getCategoryBySlug');
    Route::get('/v2/portable-apps/{id}', 'get');
});

// API v1
Route::controller(LegacyAPIController::class)->group(function () {
    Route::get('/apps', 'apps');
    Route::get('/apps/category/{id}', 'getCategoryById');
    Route::get('/apps/category/{slug}', 'getCategoryBySlug');
    Route::get('/changelog', 'changelog');
    Route::get('/website', 'website');
});
