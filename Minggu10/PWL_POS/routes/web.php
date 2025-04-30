<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\ProfileController;

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
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);
        Route::post('/level/list', [LevelController::class, 'list']); // untuk list json datatables
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/level/ajax', [LevelController::class, 'store_ajax']);
        Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']);
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // untuk tampilkan form edit
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']); // untuk proses update data
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // untuk proses update data
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // untuk proses hapus data
        Route::get('/level/import', [LevelController::class, 'import']); // ajax form upload excel
        Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel
        Route::get('/level/export_excel',[LevelController::class,'export_excel']); // export excel
        Route::get('/level/export_pdf',[LevelController::class,'export_pdf']); // export excel
    });

    // route Barang
    // Artinya semua route di dalam group ini harus punya role ADM (Administrator), MNG (Manager), dan STF (staff/kasir)
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang/list', [BarangController::class, 'list']);
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // ajax form create
        Route::post('/barang/ajax', [BarangController::class, 'store_ajax']); // ajax store
        Route::get('/barang/{id}', [BarangController::class, 'show']); // menampilkan detail barang
        Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']); // ajax form edit
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // ajax form edit
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // ajax update
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // ajax delete
        Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
        Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
        Route::get('/barang/export_excel',[BarangController::class,'export_excel']); // export excel
        Route::get('/barang/export_pdf',[BarangController::class,'export_pdf']); // export excel
    });

    // route User
    Route::middleware(['authorize:ADM'])->group(function(){
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/user/list', [UserController::class, 'list']);
        Route::get('/user/create_ajax', [UserController::class, 'create_ajax']); // ajax form create
        Route::post('/user/ajax', [UserController::class, 'store_ajax']); // ajax store
        Route::get('/user/{id}/show_ajax', [UserController::class, 'show_ajax']); // ajax form edit
        Route::get('/user/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // ajax form edit
        Route::put('/user/{id}/update_ajax', [UserController::class, 'update_ajax']); // ajax update
        Route::get('/user/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // ajax delete
        Route::get('/user/import', [UserController::class, 'import']); // ajax form upload excel
        Route::post('/user/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
        Route::get('/user/export_excel',[UserController::class,'export_excel']); // export excel
        Route::get('/user/export_pdf',[UserController::class,'export_pdf']); // export excel
    });

    // route Kategori Barang
    Route::middleware(['authorize:ADM,MNG,STF,KSR'])->group(function(){
        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::post('/kategori/list', [KategoriController::class, 'list']);
        Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']); // ajax form create
        Route::post('/kategori/ajax', [KategoriController::class, 'store_ajax']); // ajax store
        Route::get('/kategori/{id}/show_ajax', [KategoriController::class, 'show_ajax']); // ajax form edit
        Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // ajax form edit
        Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // ajax update
        Route::get('/kategori/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // ajax delete
        Route::get('/kategori/import', [KategoriController::class, 'import']); // ajax form upload excel
        Route::post('/kategori/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
        Route::get('/kategori/export_excel',[KategoriController::class,'export_excel']); // export excel
        Route::get('/kategori/export_pdf',[KategoriController::class,'export_pdf']); // export excel
    });

    // route Stok
    Route::middleware(['authorize:ADM,MNG,STF,KSR'])->group(function(){
        Route::get('/stok', [StokController::class, 'index']);
        Route::post('/stok/list', [StokController::class, 'list']);
        Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']); // ajax form create
        Route::post('/stok/ajax', [StokController::class, 'store_ajax']); // ajax store
        Route::get('/stok/{id}/show_ajax', [StokController::class, 'show_ajax']); // ajax store
        Route::get('/stok/{id}/edit_ajax', [StokController::class, 'edit_ajax']); // ajax form edit
        Route::put('/stok/{id}/update_ajax', [StokController::class, 'update_ajax']); // ajax update
        Route::get('/stok/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // ajax delete
        Route::get('/stok/import', [StokController::class, 'import']); // ajax form upload excel
        Route::post('/stok/import_ajax', [StokController::class, 'import_ajax']); // ajax import excel
        Route::get('/stok/export_excel',[StokController::class,'export_excel']); // export excel
        Route::get('/stok/export_pdf',[StokController::class,'export_pdf']); // export pdf
    });
    
    // route Supplier
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::get('/supplier', [SupplierController::class, 'index']);
        Route::post('/supplier/list', [SupplierController::class, 'list']);
        Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']); // ajax form create
        Route::post('/supplier/ajax', [SupplierController::class, 'store_ajax']); // ajax store
        Route::get('/supplier/{id}/show_ajax', [SupplierController::class, 'show_ajax']); // ajax form edit
        Route::get('/supplier/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // ajax form edit
        Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // ajax update
        Route::get('/supplier/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // ajax delete
        Route::get('/supplier/import', [SupplierController::class, 'import']); // ajax form upload excel
        Route::post('/supplier/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
        Route::get('/supplier/export_excel',[SupplierController::class,'export_excel']); // export excel
        Route::get('/supplier/export_pdf',[SupplierController::class,'export_pdf']); // export pdf
    });

    // route Penjualan
    Route::middleware(['authorize:ADM,MNG,STF,KSR'])->group(function(){
        Route::get('/penjualan', [PenjualanController::class, 'index']);
        Route::post('/penjualan/list', [PenjualanController::class, 'list']);
        Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']); // ajax form create
        Route::post('/penjualan/ajax', [PenjualanController::class, 'store_ajax']); // ajax store
        Route::get('/penjualan/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
        Route::get('/penjualan/{id}/struk_pdf', [PenjualanController::class, 'cetak_struk']);
        // Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']); // ajax form edit
        Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']); // ajax update
        Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']); // ajax delete
        Route::get('/penjualan/import', [PenjualanController::class, 'import']); // ajax form upload excel
        Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']); // ajax import excel
        Route::get('/penjualan/export_excel',[PenjualanController::class,'export_excel']); // export excel
        Route::get('/penjualan/export_pdf',[PenjualanController::class,'export_pdf']); // export pdf
    });

    // // route Penjualan Detail
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::get('/penjualanDetail', [PenjualanDetailController::class, 'index']);
        Route::get('/penjualanDetail/{id}/show', [PenjualanDetailController::class, 'show']);
    });

    // Route profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update-foto', [ProfileController::class, 'updateFoto'])->name('profile.updateFoto');
    
});