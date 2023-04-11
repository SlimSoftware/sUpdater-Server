<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AppAPIController;
use App\Http\Controllers\API\DetectInfoAPIController;
use App\Http\Controllers\API\InstallerAPIController;
use App\Http\Controllers\API\LegacyAPIController;

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
Route::get('/v2/apps/{id}', [AppAPIController::class, 'get']);
Route::get('/v2/apps/release-notes/{id}', [AppAPIController::class, 'releaseNotes']);
Route::get('/v2/apps/website/{id}', [AppAPIController::class, 'website']);

// API v1
Route::get('/apps', [LegacyAPIController::class, 'apps_v1']);
Route::get('/changelog', [AppAPIController::class, 'releaseNotes']);
Route::get('/website', [AppAPIController::class, 'website']);
