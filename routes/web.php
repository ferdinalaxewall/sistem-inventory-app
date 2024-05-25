<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [DashboardController::class, 'index'])->name('index');

Route::group([
    'as' => 'auth.'
], function () {
    Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'storeLogin'])->name('store.login');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'middleware' => 'auth'
], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});
