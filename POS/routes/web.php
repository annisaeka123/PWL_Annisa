<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postregister']);

Route::middleware('auth')->group(function(){ // artinya semua route di dalam group ini harus login dulu

    // masukkan semua route yang perlu autentikasi di sini
        Route::get('/', [WelcomeController::class, 'index']);
    
    // route Level
    // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);
        Route::post('/level/list', [LevelController::class, 'list']); // untuk list json datatables
        Route::get('/level/create', [LevelController::class, 'create']);
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/level', [LevelController::class, 'store']);
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']); // untuk tampilkan form edit
        Route::put('/level/{id}', [LevelController::class, 'update']); // untuk proses update data
        Route::delete('/level/{id}', [LevelController::class, 'destroy']); // untuk proses hapus data
    });

    // route Barang
    // Artinya semua route di dalam group ini harus punya role ADM (Administrator), MNG (Manager), dan STF (staff/kasir)
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang/list', [BarangController::class, 'list']);
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // ajax form create
        Route::post('/barang/store_ajax', [BarangController::class, 'store_ajax']); // ajax store
        Route::get('/barang/{id}', [BarangController::class, 'show']); // menampilkan detail barang
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // ajax form edit
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // ajax update
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // ajax delete
    });

    // route User
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/user/list', [UserController::class, 'list']);
        Route::get('/user/create_ajax', [UserController::class, 'create_ajax']); // ajax form create
        Route::post('/user/store_ajax', [UserController::class, 'store_ajax']); // ajax store
        Route::get('/user/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // ajax form edit
        Route::put('/user/{id}/update_ajax', [UserController::class, 'update_ajax']); // ajax update
        Route::get('/user/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // ajax delete
    });

    // route Kategori Barang
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::post('/kategori/list', [KategoriController::class, 'list']);
        Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']); // ajax form create
        Route::post('/kategori/store_ajax', [KategoriController::class, 'store_ajax']); // ajax store
        Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // ajax form edit
        Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // ajax update
        Route::get('/kategori/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // ajax delete
    });

    // route Stok
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::get('/stok', [StokController::class, 'index']);
        Route::post('/stok/list', [StokController::class, 'list']);
        Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']); // ajax form create
        Route::post('/stok/store_ajax', [StokController::class, 'store_ajax']); // ajax store
        Route::get('/stok/{id}/edit_ajax', [StokController::class, 'edit_ajax']); // ajax form edit
        Route::put('/stok/{id}/update_ajax', [StokController::class, 'update_ajax']); // ajax update
        Route::get('/stok/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // ajax delete
    });
    
    // route Supplier
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::get('/supplier', [SupplierController::class, 'index']);
        Route::post('/supplier/list', [SupplierController::class, 'list']);
        Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']); // ajax form create
        Route::post('/supplier/store_ajax', [SupplierController::class, 'store_ajax']); // ajax store
        Route::get('/supplier/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // ajax form edit
        Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // ajax update
        Route::get('/supplier/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // ajax delete
    });

    // route Penjualan
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::get('/penjualan', [PenjualanController::class, 'index']);
        Route::post('/penjualan/list', [PenjualanController::class, 'list']);
        Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']); // ajax form create
        Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']); // ajax form edit
        Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']); // ajax update
        Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']); // ajax delete
    });

    // route Penjualan Detail
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::get('/', [PenjualanDetailController::class, 'index']);
        Route::get('/{id}', [PenjualanDetailController::class, 'show']);
    });
    
});