<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AppAPIController;
use App\Http\Controllers\API\DetectInfoAPIController;
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

Route::get('/v2/apps/{id}', [AppAPIController::class, 'get']);
Route::delete('/v2/apps/{id}', [AppAPIController::class, 'delete']);

Route::get('/v2/detectinfo/{id}', [DetectInfoAPIController::class, 'get']);
Route::get('/v2/installers/{id}', [DetectInfoAPIController::class, 'get']);

Route::get('/v1/apps', [LegacyAPIController::class, 'apps_v1']);
