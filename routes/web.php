<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Report\StockController;
use App\Http\Controllers\Dashboard\Transaction\SaleController;
use App\Http\Controllers\Dashboard\Report\ReportSaleController;
use App\Http\Controllers\Dashboard\MasterData\CustomerController;
use App\Http\Controllers\Dashboard\MasterData\SupplierController;
use App\Http\Controllers\Dashboard\MasterData\Item\ItemController;
use App\Http\Controllers\Dashboard\MasterData\User\UserController;
use App\Http\Controllers\Dashboard\MasterData\User\AdminController;
use App\Http\Controllers\Dashboard\Transaction\IncomingGoodsController;
use App\Http\Controllers\Dashboard\Report\ReportIncomingGoodsController;
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

    Route::get('/register', [AuthController::class, 'viewRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegister'])->name('store.register');

    Route::get('/verifikasi-akun/{user}', [AuthController::class, 'viewVerifyAccount'])->name('verify-account');
    Route::post('/verifikasi-akun/{user}', [AuthController::class, 'storeVerifyAccount'])->name('store.verify-account');
    Route::get('/verifikasi-akun/kirim-ulang-kode/{user}', [AuthController::class, 'resendVerifyCode'])->name('resend-code');

    Route::get('/template-email', function (){
        $verifyCode = 123123;
        $user_name = 'Muhamad Ferdinal';
        $user_id = Str::uuid();

    return view('templates.mail.verify-code', compact('verifyCode', 'user_name', 'user_id'));
    });

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
            'as' => 'users.', 
            'middleware' => 'isAdmin'
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

                Route::get('/export/excel', [AdminController::class, 'exportToExcel'])->name('export.excel');
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

                Route::get('/export/excel', [UserController::class, 'exportToExcel'])->name('export.excel');
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

                Route::get('/export/excel', [ItemController::class, 'exportToExcel'])->name('export.excel');
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

            Route::get('/export/excel', [CustomerController::class, 'exportToExcel'])->name('export.excel');
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

            Route::get('/export/excel', [SupplierController::class, 'exportToExcel'])->name('export.excel');
        });
    });

    Route::group([
        'prefix' => 'transaksi',
        'as' => 'transaction.'
    ], function () {
        Route::group([
            'prefix' => 'barang-masuk',
            'as' => 'incoming.'
        ], function () {
            Route::get('/', [IncomingGoodsController::class, 'index'])->name('index');
            Route::get('/create', [IncomingGoodsController::class, 'create'])->name('create');
            Route::post('/', [IncomingGoodsController::class, 'store'])->name('store');
            Route::delete('/delete/{uuid}', [IncomingGoodsController::class, 'delete'])->name('delete');

            Route::get('/export/excel', [IncomingGoodsController::class, 'exportToExcel'])->name('export.excel');
        });

        Route::group([
            'prefix' => 'transaksi-penjualan',
            'as' => 'sale.'
        ], function () {
            Route::get('/', [SaleController::class, 'index'])->name('index');
            Route::get('/create', [SaleController::class, 'create'])->name('create');
            Route::post('/', [SaleController::class, 'store'])->name('store');
            Route::delete('/delete/{uuid}', [SaleController::class, 'delete'])->name('delete');
            
            Route::get('/export/excel', [SaleController::class, 'exportToExcel'])->name('export.excel');
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

        Route::group([
            'prefix' => 'barang-masuk',
            'as' => 'incoming.',
        ], function () {
            Route::get('/', [ReportIncomingGoodsController::class, 'incomingReport'])->name('index');
        });

        Route::group([
            'prefix' => 'transaksi-penjualan',
            'as' => 'sale.',
        ], function () {
            Route::get('/', [ReportSaleController::class, 'saleReport'])->name('index');
        });
    });
});
