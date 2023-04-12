<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DetectInfoController;
use App\Http\Controllers\PortableAppController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::redirect('/', '/apps');

Route::get('/apps', [AppController::class, 'index'])->name('apps');

Route::get('/apps/new', [AppController::class, 'new'])->name('apps.new');
Route::post('/apps/new', [AppController::class, 'create']);

Route::get('/apps/edit/{id}', [AppController::class, 'edit'])->name('apps.edit');
Route::put('/apps/edit/{id}', [AppController::class, 'update']);

Route::post('/apps/edit/detectinfo', [DetectInfoController::class, 'create']);
Route::put('/apps/edit/detectinfo/{id}', [DetectInfoController::class, 'update']);
Route::delete('/apps/edit/detectinfo/{id}', [DetectInfoController::class, 'delete']);

Route::delete('/apps/delete/{id}', [AppController::class, 'delete'])->name('apps.delete');

Route::get('/portable-apps', [PortableAppController::class, 'index'])->name('portable_apps');

Route::get('/portable-apps/new', [PortableAppController::class, 'new'])->name('portable_apps.new');

Route::get('/portable-apps/edit/{id}', [PortableAppController::class, 'edit'])->name('portable_apps.edit');
