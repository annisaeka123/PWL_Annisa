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

// Halaman Home
Route::get('/', [HomeController::class, 'index']);

Route::get('/user', [UserController::class, 'index']);
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

Route::get('/level', [LevelController::class, 'index']);
Route::get('/level/tambah', [LevelController::class, 'tambah']);
Route::post('/level/tambah_simpan', [LevelController::class, 'tambah_simpan']);
Route::get('/level/ubah/{id}', [LevelController::class, 'ubah']);
Route::put('/level/ubah_simpan/{id}', [LevelController::class, 'ubah_simpan']);
Route::get('/level/hapus/{id}', [LevelController::class, 'hapus']);

Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/tambah', [KategoriController::class, 'tambah']);
Route::post('/kategori/tambah_simpan', [KategoriController::class, 'tambah_simpan']);
Route::get('/kategori/ubah/{id}', [KategoriController::class, 'ubah']);
Route::put('/kategori/ubah_simpan/{id}', [KategoriController::class, 'ubah_simpan']);
Route::get('/kategori/hapus/{id}', [KategoriController::class, 'hapus']);

Route::get('/barang', [BarangController::class, 'index']);
Route::get('/barang/tambah', [BarangController::class, 'tambah']);
Route::post('/barang/tambah_simpan', [BarangController::class, 'tambah_simpan']);
Route::get('/barang/ubah/{id}', [BarangController::class, 'ubah']);
Route::put('/barang/ubah_simpan/{id}', [BarangController::class, 'ubah_simpan']);
Route::get('/barang/hapus/{id}', [BarangController::class, 'hapus']);

Route::get('/supplier', [SupplierController::class, 'index']);
Route::get('/supplier/tambah', [SupplierController::class, 'tambah']);
Route::post('/supplier/tambah_simpan', [SupplierController::class, 'tambah_simpan']);
Route::get('/supplier/ubah/{id}', [SupplierController::class, 'ubah']);
Route::put('/supplier/ubah_simpan/{id}', [SupplierController::class, 'ubah_simpan']);
Route::get('/supplier/hapus/{id}', [SupplierController::class, 'hapus']);

Route::get('/stok', [StokController::class, 'index']);
Route::get('/stok/tambah', [StokController::class, 'tambah']);
Route::post('/stok/tambah_simpan', [StokController::class, 'tambah_simpan']);
Route::get('/stok/ubah/{id}', [StokController::class, 'ubah']);
Route::put('/stok/ubah_simpan/{id}', [StokController::class, 'ubah_simpan']);
Route::get('/stok/hapus/{id}', [StokController::class, 'hapus']);

Route::get('/penjualan', [PenjualanController::class, 'index']);
Route::get('/penjualan/tambah', [PenjualanController::class, 'tambah']);
Route::post('/penjualan/tambah_simpan', [PenjualanController::class, 'tambah_simpan']);
Route::get('/penjualan/ubah/{id}', [PenjualanController::class, 'ubah']);
Route::put('/penjualan/ubah_simpan/{id}', [PenjualanController::class, 'ubah_simpan']);
Route::get('/penjualan/hapus/{id}', [PenjualanController::class, 'hapus']);

Route::get('penjualan_detail', [PenjualanDetailController::class, 'index']);
Route::get('penjualan_detail/tambah', [PenjualanDetailController::class, 'tambah']);
Route::post('penjualan_detail/tambah_simpan', [PenjualanDetailController::class, 'tambah_simpan']);
Route::get('penjualan_detail/ubah/{id}', [PenjualanDetailController::class, 'ubah']);
Route::put('penjualan_detail/ubah_simpan/{id}', [PenjualanDetailController::class, 'ubah_simpan']);
Route::get('penjualan_detail/hapus/{id}', [PenjualanDetailController::class, 'hapus']);
