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
        Route::post('/level', [LevelController::class, 'show']);
        Route::post('/level/store_ajax', [LevelController::class, 'store_ajax']);
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']); // untuk tampilkan form edit
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // untuk tampilkan form edit
        Route::put('/level/{id}', [LevelController::class, 'update']); // untuk proses update data
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']); // untuk proses update data
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete level Ajax
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data level Ajax
        Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
        Route::get('/level/import', [LevelController::class, 'import']); // ajax form upload excel
        Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel
        Route::get('/level/export_excel',[LevelController::class,'export_excel']); // export excel
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
        Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
        Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
        Route::get('/barang/export_excel',[BarangController::class,'export_excel']); // export excel
    });

    // route Barang
    // akses terbatas untuk user CUS (customer) yaitu hanya bisa melihat list barang tetapi tidak bisa CRUD
    Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function(){
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang/list', [BarangController::class, 'list']);
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
        Route::get('/user/import', [UserController::class, 'import']); // ajax form upload excel
        Route::post('/user/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
        Route::get('/user/export_excel',[UserController::class,'export_excel']); // export excel
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
        Route::get('/kategori/import', [KategoriController::class, 'import']); // ajax form upload excel
        Route::post('/kategori/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
        Route::get('/kategori/export_excel',[KategoriController::class,'export_excel']); // export excel
    });

    // route Kategori Barang
    Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function(){
        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::post('/kategori/list', [KategoriController::class, 'list']);
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
        Route::get('/stok/import', [StokController::class, 'import']); // ajax form upload excel
        Route::post('/stok/import_ajax', [StokController::class, 'import_ajax']); // ajax import excel
        Route::get('/stok/export_excel',[StokController::class,'export_excel']); // export excel
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
        Route::get('/supplier/import', [SupplierController::class, 'import']); // ajax form upload excel
        Route::post('/supplier/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
        Route::get('/supplier/export_excel',[SupplierController::class,'export_excel']); // export excel
    });
    
});


    // ------------------------ 
    // Jobsheet 6
    // ------------------------

    // Route::group(['prefix' => 'user'], function () {

    //     Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
    //     Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
    //     Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
    //     Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
    //     Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    //     Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
    //     Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
    //     Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
    //     Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
    //     Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax
    //     Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user Ajax
    //     Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    //     Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    //     Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user

    // });

    // Route::group(['prefix' => 'kategori'], function () {
    //     Route::get('/', [KategoriController::class, 'index']); // menampilkan halaman awal Kategori
    //     Route::post('/list', [KategoriController::class, 'list']); // menampilkan data Kategori dalam bentuk json untuk datatables
    //     Route::get('/create', [KategoriController::class, 'create']); // menampilkan halaman form tambah Kategori
    //     Route::post('/', [KategoriController::class, 'store']); // menyimpan data Kategori baru
    //     Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // Menampilkan halaman form tambah Kategori Ajax
    //     Route::post('/ajax', [KategoriController::class, 'store_ajax']); // Menyimpan data Kategori baru Ajax
    //     Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail Kategori
    //     Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit Kategori
    //     Route::put('/{id}', [KategoriController::class, 'update']); // menyimpan perubahan data Kategori
    //     Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // Menampilkan halaman form edit Kategori Ajax
    //     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // Menyimpan perubahan data Kategori Ajax
    //     Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Kategori Ajax
    //     Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk hapus data Kategori Ajax
    //     Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data Kategori
    // });

    // Route::group(['prefix' => 'stok'], function () {
    //     Route::get('/', [StokController::class, 'index']); // menampilkan halaman awal Stok
    //     Route::post('/list', [StokController::class, 'list']); // menampilkan data Stok dalam bentuk json untuk datatables
    //     Route::get('/create', [StokController::class, 'create']); // menampilkan halaman form tambah Stok
    //     Route::post('/', [StokController::class, 'store']); // menyimpan data Stok baru
    //     Route::get('/create_ajax', [StokController::class, 'create_ajax']); // Menampilkan halaman form tambah Stok Ajax
    //     Route::post('/ajax', [StokController::class, 'store_ajax']); // Menyimpan data Stok baru Ajax
    //     Route::get('/{id}', [StokController::class, 'show']); // menampilkan detail Stok
    //     Route::get('/{id}/edit', [StokController::class, 'edit']); // menampilkan halaman form edit Stok
    //     Route::put('/{id}', [StokController::class, 'update']); // menyimpan perubahan data Stok
    //     Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']); // Menampilkan halaman form edit Stok Ajax
    //     Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']); // Menyimpan perubahan data Stok Ajax
    //     Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Stok Ajax
    //     Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // Untuk hapus data Stok Ajax
    //     Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data Stok
    // });

    // Route::group(['prefix' => 'supplier'], function () {
    //     Route::get('/', [SupplierController::class, 'index']); // menampilkan halaman awal Supplier
    //     Route::post('/list', [SupplierController::class, 'list']); // menampilkan data Supplier dalam bentuk json untuk datatables
    //     Route::get('/create', [SupplierController::class, 'create']); // menampilkan halaman form tambah Supplier
    //     Route::post('/', [SupplierController::class, 'store']); // menyimpan data Supplier baru
    //     Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah Supplier Ajax
    //     Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Menyimpan data Supplier baru Ajax
    //     Route::get('/{id}', [SupplierController::class, 'show']); // menampilkan detail Supplier
    //     Route::get('/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit Supplier
    //     Route::put('/{id}', [SupplierController::class, 'update']); // menyimpan perubahan data Supplier
    //     Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // Menampilkan halaman form edit Supplier Ajax
    //     Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // Menyimpan perubahan data Supplier Ajax
    //     Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Supplier Ajax
    //     Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data Supplier Ajax
    //     Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data Supplier
    // });

    // Route::group(['prefix' => 'barang'], function () {
    //     Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal Barang
    //     Route::post('/list', [BarangController::class, 'list']); // menampilkan data Barang dalam bentuk json untuk datatables
    //     Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah Barang
    //     Route::post('/', [BarangController::class, 'store']); // menyimpan data Barang baru
    //     Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah Barang Ajax
    //     Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menyimpan data Barang baru Ajax
    //     Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail Barang
    //     Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit Barang
    //     Route::put('/{id}', [BarangController::class, 'update']); // menyimpan perubahan data Barang
    //     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit Barang Ajax
    //     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data Barang Ajax
    //     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Barang Ajax
    //     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data Barang Ajax
    //     Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data Barang
    // });
    

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