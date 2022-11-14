<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/apps', [AppController::class, 'index'])->name('apps');

Route::get('/apps/edit/{id}', [AppController::class, 'edit'])->name('apps.edit');

Route::get('/portable-apps', function () {
    return view('portable_apps');
})->name('portable_apps');
