<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\KategoriModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\StokModel;

class WelcomeController extends Controller
{
    public function index()
    {
        // Membuat breadcrumb
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        // Mengambil 10 transaksi penjualan terbaru
        $latestPenjualan = PenjualanModel::with('user')->latest('penjualan_tanggal')->take(10)->get();

        // Menghitung jumlah entitas untuk kategori, barang, supplier, dan stok
        $kategoriCount = KategoriModel::count();
        $barangCount = BarangModel::count();
        $supplierCount = SupplierModel::count();
        $stokCount = StokModel::count();

        // Menetapkan menu aktif
        $activeMenu = 'dashboard';

        // Mengembalikan view dengan data breadcrumb, activeMenu, latestPenjualan, dan counts
        return view('welcome', compact(
            'breadcrumb', 
            'activeMenu', 
            'latestPenjualan', 
            'kategoriCount', 
            'barangCount', 
            'supplierCount', 
            'stokCount'
        ));
    }
}
