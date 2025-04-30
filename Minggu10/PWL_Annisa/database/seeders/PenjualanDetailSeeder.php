<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['detail_id' => 1, 'penjualan_id' => 1, 'barang_id' => 1, 'harga' => 240000, 'jumlah' => 2],            
            ['detail_id' => 2, 'penjualan_id' => 2, 'barang_id' => 3, 'harga' => 7350000, 'jumlah' => 1],            
            ['detail_id' => 3, 'penjualan_id' => 3, 'barang_id' => 5, 'harga' => 39000, 'jumlah' => 3],            
            ['detail_id' => 4, 'penjualan_id' => 4, 'barang_id' => 7, 'harga' => 35000, 'jumlah' => 5],
            ['detail_id' => 5, 'penjualan_id' => 5, 'barang_id' => 9, 'harga' => 300000, 'jumlah' => 1],
        ];
        
        // Insert ke tabel t_penjualan_detail
        DB::table('t_penjualan_detail')->insert($data);
    }
}