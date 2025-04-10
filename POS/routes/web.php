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

Route::get('/level', [LevelController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/barang', [BarangController::class, 'index']);
Route::get('/supplier', [SupplierController::class, 'index']);
Route::get('/stok', [StokController::class, 'index']);
Route::get('/penjualan', [PenjualanController::class, 'index']);
Route::get('/penjualan_detail', [PenjualanDetailController::class, 'index']);
