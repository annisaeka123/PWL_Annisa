<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'kategori_id' =>1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Gamis', 'harga_beli' => 100000, 'harga_jual' => 120000],
            ['barang_id' => 2, 'kategori_id' =>1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Tunik', 'harga_beli' => 85000, 'harga_jual' => 100000],
            ['barang_id' => 3, 'kategori_id' =>2, 'barang_kode' => 'BRG003', 'barang_nama' => 'Laptop', 'harga_beli' => 7350000, 'harga_jual' => 7550000],
            ['barang_id' => 4, 'kategori_id' =>2, 'barang_kode' => 'BRG004', 'barang_nama' => 'Kulkas', 'harga_beli' => 5000000, 'harga_jual' => 5200000],
            ['barang_id' => 5, 'kategori_id' =>3, 'barang_kode' => 'BRG005', 'barang_nama' => 'Biskuit', 'harga_beli' => 10000, 'harga_jual' => 13000],
            ['barang_id' => 6, 'kategori_id' =>3, 'barang_kode' => 'BRG006', 'barang_nama' => 'Roti', 'harga_beli' => 21000, 'harga_jual' => 27000],
            ['barang_id' => 7, 'kategori_id' =>4, 'barang_kode' => 'BRG007', 'barang_nama' => 'Teh', 'harga_beli' => 5000, 'harga_jual' => 7000],
            ['barang_id' => 8, 'kategori_id' =>4, 'barang_kode' => 'BRG008', 'barang_nama' => 'Susu', 'harga_beli' => 6000, 'harga_jual' => 8000],
            ['barang_id' => 9, 'kategori_id' =>5, 'barang_kode' => 'BRG009', 'barang_nama' => 'Meja', 'harga_beli' => 235000, 'harga_jual' => 300000],
            ['barang_id' => 10, 'kategori_id' =>5, 'barang_kode' => 'BRG010', 'barang_nama' => 'Kasur', 'harga_beli' => 450000, 'harga_jual' => 500000],
        ];
        
        // Insert ke tabel m_barang
        DB::table('m_barang')->insert($data);
    }
}