<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;

// ------------------------ 
// JOBSHEET 7
// ------------------------

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function(){ // artinya semua route di dalam group ini harus login dulu

    // masukkan semua route yang perlu autentikasi di sini
        Route::get('/', [WelcomeController::class, 'index']);
    // route Level

    // artinya semua route di dalam group ini harus punya role ADM (Administrator)
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);
        Route::post('/level/list', [LevelController::class, 'list']); // untuk list json datatables
        Route::get('/level/create', [LevelController::class, 'create']);
        Route::post('/level', [LevelController::class, 'store']);
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']); // untuk tampilkan form edit
        Route::put('/level/{id}', [LevelController::class, 'update']); // untuk proses update data
        Route::delete('/level/{id}', [LevelController::class, 'destroy']); // untuk proses hapus data
    });
    
    // ------------------------ 
    // Jobsheet 6
    // ------------------------

    Route::group(['prefix' => 'user'], function () {

        Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
        Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
        Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
        Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
        Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
        Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
        Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user Ajax
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
        Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user

    });

    Route::group(['prefix' => 'kategori'], function () {
        Route::get('/', [KategoriController::class, 'index']); // menampilkan halaman awal Kategori
        Route::post('/list', [KategoriController::class, 'list']); // menampilkan data Kategori dalam bentuk json untuk datatables
        Route::get('/create', [KategoriController::class, 'create']); // menampilkan halaman form tambah Kategori
        Route::post('/', [KategoriController::class, 'store']); // menyimpan data Kategori baru
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // Menampilkan halaman form tambah Kategori Ajax
        Route::post('/ajax', [KategoriController::class, 'store_ajax']); // Menyimpan data Kategori baru Ajax
        Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail Kategori
        Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit Kategori
        Route::put('/{id}', [KategoriController::class, 'update']); // menyimpan perubahan data Kategori
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // Menampilkan halaman form edit Kategori Ajax
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // Menyimpan perubahan data Kategori Ajax
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Kategori Ajax
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk hapus data Kategori Ajax
        Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data Kategori
    });

    Route::group(['prefix' => 'stok'], function () {
        Route::get('/', [StokController::class, 'index']); // menampilkan halaman awal Stok
        Route::post('/list', [StokController::class, 'list']); // menampilkan data Stok dalam bentuk json untuk datatables
        Route::get('/create', [StokController::class, 'create']); // menampilkan halaman form tambah Stok
        Route::post('/', [StokController::class, 'store']); // menyimpan data Stok baru
        Route::get('/create_ajax', [StokController::class, 'create_ajax']); // Menampilkan halaman form tambah Stok Ajax
        Route::post('/ajax', [StokController::class, 'store_ajax']); // Menyimpan data Stok baru Ajax
        Route::get('/{id}', [StokController::class, 'show']); // menampilkan detail Stok
        Route::get('/{id}/edit', [StokController::class, 'edit']); // menampilkan halaman form edit Stok
        Route::put('/{id}', [StokController::class, 'update']); // menyimpan perubahan data Stok
        Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']); // Menampilkan halaman form edit Stok Ajax
        Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']); // Menyimpan perubahan data Stok Ajax
        Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Stok Ajax
        Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // Untuk hapus data Stok Ajax
        Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data Stok
    });

    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', [SupplierController::class, 'index']); // menampilkan halaman awal Supplier
        Route::post('/list', [SupplierController::class, 'list']); // menampilkan data Supplier dalam bentuk json untuk datatables
        Route::get('/create', [SupplierController::class, 'create']); // menampilkan halaman form tambah Supplier
        Route::post('/', [SupplierController::class, 'store']); // menyimpan data Supplier baru
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah Supplier Ajax
        Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Menyimpan data Supplier baru Ajax
        Route::get('/{id}', [SupplierController::class, 'show']); // menampilkan detail Supplier
        Route::get('/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit Supplier
        Route::put('/{id}', [SupplierController::class, 'update']); // menyimpan perubahan data Supplier
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // Menampilkan halaman form edit Supplier Ajax
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // Menyimpan perubahan data Supplier Ajax
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Supplier Ajax
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data Supplier Ajax
        Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data Supplier
    });

    Route::group(['prefix' => 'barang'], function () {
        Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal Barang
        Route::post('/list', [BarangController::class, 'list']); // menampilkan data Barang dalam bentuk json untuk datatables
        Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah Barang
        Route::post('/', [BarangController::class, 'store']); // menyimpan data Barang baru
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah Barang Ajax
        Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menyimpan data Barang baru Ajax
        Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail Barang
        Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit Barang
        Route::put('/{id}', [BarangController::class, 'update']); // menyimpan perubahan data Barang
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit Barang Ajax
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data Barang Ajax
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Barang Ajax
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data Barang Ajax
        Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data Barang
    });


});


// ------------------------
// Jobsheet 6
// ------------------------
// Route::group(['prefix' => 'level'], function () {

//     Route::get('/', [LevelController::class, 'index']); // menampilkan halaman awal level
//     Route::post('/list', [LevelController::class, 'list']); // menampilkan data level dalam bentuk json untuk datatables
//     Route::get('/create', [LevelController::class, 'create']); // menampilkan halaman form tambah level
//     Route::post('/', [LevelController::class, 'store']); // menyimpan data level baru
//     Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // Menampilkan halaman form tambah level Ajax
//     Route::post('/ajax', [LevelController::class, 'store_ajax']); // Menyimpan data level baru Ajax
//     Route::get('/{id}', [LevelController::class, 'show']); // menampilkan detail level
//     Route::get('/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit level
//     Route::put('/{id}', [LevelController::class, 'update']); // menyimpan perubahan data level
//     Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // menampilkan halaman form edit level Ajax
//     Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // menyimpan perubahan data level Ajax
//     Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete level Ajax
//     Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data level Ajax
//     Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level

// });


// ------------------------
// Jobsheet 5
// ------------------------
// Route::get('/', [WelcomeController::class, 'index']);

// Route::group(['prefix' => 'user'], function () {

//     Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
//     Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
//     Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
//     Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
//     Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
//     Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
//     Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
//     Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user

// });

// Route::group(['prefix' => 'level'], function () {

//     Route::get('/', [LevelController::class, 'index']); // menampilkan halaman awal level
//     Route::post('/list', [LevelController::class, 'list']); // menampilkan data level dalam bentuk json untuk datatables
//     Route::get('/create', [LevelController::class, 'create']); // menampilkan halaman form tambah level
//     Route::post('/', [LevelController::class, 'store']); // menyimpan data level baru
//     Route::get('/{id}', [LevelController::class, 'show']); // menampilkan detail level
//     Route::get('/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit level
//     Route::put('/{id}', [LevelController::class, 'update']); // menyimpan perubahan data level
//     Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level

// });

// Route::group(['prefix' => 'kategori'], function () {

//     Route::get('/', [KategoriController::class, 'index']);
//     Route::post('/list', [KategoriController::class, 'list']);
//     Route::get('/create', [KategoriController::class, 'create']); 
//     Route::post('/', [KategoriController::class, 'store']);
//     Route::get('/{id}', [KategoriController::class, 'show']); 
//     Route::get('/{id}/edit', [KategoriController::class, 'edit']); 
//     Route::put('/{id}', [KategoriController::class, 'update']); 
//     Route::delete('/{id}', [KategoriController::class, 'destroy']);

// });

// Route::group(['prefix' => 'stok'], function () {

//     Route::get('/', [StokController::class, 'index']);
//     Route::post('/list', [StokController::class, 'list']);
//     Route::get('/create', [StokController::class, 'create']); 
//     Route::post('/', [StokController::class, 'store']);
//     Route::get('/{id}', [StokController::class, 'show']); 
//     Route::get('/{id}/edit', [StokController::class, 'edit']); 
//     Route::put('/{id}', [StokController::class, 'update']); 
//     Route::delete('/{id}', [StokController::class, 'destroy']);

// });

// Route::group(['prefix' => 'supplier'], function () {

//     Route::get('/', [SupplierController::class, 'index']);
//     Route::post('/list', [SupplierController::class, 'list']);
//     Route::get('/create', [SupplierController::class, 'create']); 
//     Route::post('/', [SupplierController::class, 'store']);
//     Route::get('/{id}', [SupplierController::class, 'show']); 
//     Route::get('/{id}/edit', [SupplierController::class, 'edit']); 
//     Route::put('/{id}', [SupplierController::class, 'update']); 
//     Route::delete('/{id}', [SupplierController::class, 'destroy']);

// });

// Route::group(['prefix' => 'barang'], function () {

//     Route::get('/', [BarangController::class, 'index']);
//     Route::post('/list', [BarangController::class, 'list']);
//     Route::get('/create', [BarangController::class, 'create']);
//     Route::post('/', [BarangController::class, 'store']);
//     Route::get('/{id}', [BarangController::class, 'show']);
//     Route::get('/{id}/edit', [BarangController::class, 'edit']);
//     Route::put('/{id}', [BarangController::class, 'update']);
//     Route::delete('/{id}', [BarangController::class, 'destroy']);

// });