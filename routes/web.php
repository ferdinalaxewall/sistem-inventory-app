<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\MasterData\CustomerController;
use App\Http\Controllers\Dashboard\MasterData\Item\ItemCategoryController;
use App\Http\Controllers\Dashboard\MasterData\SupplierController;
use App\Http\Controllers\Dashboard\MasterData\User\AdminController;
use App\Http\Controllers\Dashboard\MasterData\User\UserController;
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

    Route::group([
        'prefix' => 'master-data'
    ], function (){
        Route::group([
            'prefix' => 'users',
            'as' => 'users.'
        ], function () {

            Route::group([
                'prefix' => 'administrator',
                'as' => 'administrator.'
            ], function (){
                Route::get('/', [AdminController::class, 'index'])->name('index');
                Route::get('/create', [AdminController::class, 'create'])->name('create');
                Route::post('/', [AdminController::class, 'store'])->name('store');
                Route::get('/edit/{uuid}', [AdminController::class, 'edit'])->name('edit');
                Route::put('/update/{uuid}', [AdminController::class, 'update'])->name('update');
                Route::delete('/delete/{uuid}', [AdminController::class, 'delete'])->name('delete');
            });

            Route::group([
                'prefix' => 'user',
                'as' => 'user.'
            ], function (){
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/', [UserController::class, 'store'])->name('store');
                Route::get('/edit/{uuid}', [UserController::class, 'edit'])->name('edit');
                Route::put('/update/{uuid}', [UserController::class, 'update'])->name('update');
                Route::delete('/delete/{uuid}', [UserController::class, 'delete'])->name('delete');
            });
        });

        Route::group([
            'prefix' => 'barang',
            'as' => 'items.' 
        ], function () {

            Route::group([
                'prefix' => 'kategori-barang',
                'as' => 'category.'
            ], function () {
                Route::get('/', [ItemCategoryController::class, 'index'])->name('index');
                Route::get('/create', [ItemCategoryController::class, 'create'])->name('create');
                Route::post('/', [ItemCategoryController::class, 'store'])->name('store');
                Route::get('/edit/{uuid}', [ItemCategoryController::class, 'edit'])->name('edit');
                Route::put('/update/{uuid}', [ItemCategoryController::class, 'update'])->name('update');
                Route::delete('/delete/{uuid}', [ItemCategoryController::class, 'delete'])->name('delete');
            });
        });

        Route::group([
            'prefix' => 'customer',
            'as' => 'customer.'
        ], function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/create', [CustomerController::class, 'create'])->name('create');
            Route::post('/', [CustomerController::class, 'store'])->name('store');
            Route::get('/edit/{uuid}', [CustomerController::class, 'edit'])->name('edit');
            Route::put('/update/{uuid}', [CustomerController::class, 'update'])->name('update');
            Route::delete('/delete/{uuid}', [CustomerController::class, 'delete'])->name('delete');
        });

        Route::group([
            'prefix' => 'supplier',
            'as' => 'supplier.'
        ], function () {
            Route::get('/', [SupplierController::class, 'index'])->name('index');
            Route::get('/create', [SupplierController::class, 'create'])->name('create');
            Route::post('/', [SupplierController::class, 'store'])->name('store');
            Route::get('/edit/{uuid}', [SupplierController::class, 'edit'])->name('edit');
            Route::put('/update/{uuid}', [SupplierController::class, 'update'])->name('update');
            Route::delete('/delete/{uuid}', [SupplierController::class, 'delete'])->name('delete');
        });
    });
});
