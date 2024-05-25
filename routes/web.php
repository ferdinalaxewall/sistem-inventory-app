<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Report\StockController;
use App\Http\Controllers\Dashboard\MasterData\CustomerController;
use App\Http\Controllers\Dashboard\MasterData\SupplierController;
use App\Http\Controllers\Dashboard\MasterData\Item\ItemController;
use App\Http\Controllers\Dashboard\MasterData\User\UserController;
use App\Http\Controllers\Dashboard\MasterData\User\AdminController;
use App\Http\Controllers\Dashboard\MasterData\Item\ItemCategoryController;

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


Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

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
    Route::get('/profil-saya', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profil-saya', [ProfileController::class, 'update'])->name("profile.update");

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
                'as' => 'item.'
            ], function () {
                Route::get('/', [ItemController::class, 'index'])->name('index');
                Route::get('/create', [ItemController::class, 'create'])->name('create');
                Route::post('/', [ItemController::class, 'store'])->name('store');
                Route::get('/edit/{uuid}', [ItemController::class, 'edit'])->name('edit');
                Route::put('/update/{uuid}', [ItemController::class, 'update'])->name('update');
                Route::delete('/delete/{uuid}', [ItemController::class, 'delete'])->name('delete');
            });

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

    Route::group([
        'prefix' => 'laporan',
        'as' => 'report.'
    ], function (){
        Route::group([
            'prefix' => 'stok',
            'as' => 'stock.',
        ], function () {
            Route::get('/', [StockController::class, 'stockReport'])->name('index');
        });
    });
});
