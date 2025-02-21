<?php

use App\Http\Controllers\StokController; //Mengimpor StokController agar dapat digunakan untuk menangani permintaan terkait stok.
use Illuminate\Support\Facades\Route; //Mengimpor Route agar bisa mendefinisikan rute aplikasi.

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

/**
 * Jika pengguna mengakses beranda (/), maka akan diarahkan ke tampilan welcome.blade.php.
 */
Route::get('/', function () {
    return view('welcome');
});

Route::resource('stoks', StokController::class); //Laravel secara otomatis membuat rute CRUD untuk stok berdasarkan StokController.
