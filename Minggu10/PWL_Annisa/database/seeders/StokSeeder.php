<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['stok_id' => 1, 'barang_id' => 1, 'user_id' => 1, 'supplier_id' => 1, 'stok_tanggal' => Carbon::parse('2024-04-02 14:20:00'), 'stok_jumlah' => 70],
            ['stok_id' => 2, 'barang_id' => 2, 'user_id' => 1, 'supplier_id' => 1, 'stok_tanggal' => Carbon::parse('2024-04-02 14:20:00'), 'stok_jumlah' => 65],
            ['stok_id' => 3, 'barang_id' => 3, 'user_id' => 1, 'supplier_id' => 1, 'stok_tanggal' => Carbon::parse('2024-04-02 14:20:00'), 'stok_jumlah' => 60],
            ['stok_id' => 4, 'barang_id' => 4, 'user_id' => 1, 'supplier_id' => 1, 'stok_tanggal' => Carbon::parse('2024-04-02 14:20:00'), 'stok_jumlah' => 55],
            ['stok_id' => 5, 'barang_id' => 5, 'user_id' => 2, 'supplier_id' => 2, 'stok_tanggal' => Carbon::parse('2024-04-02 15:20:00'), 'stok_jumlah' => 50],
            ['stok_id' => 6, 'barang_id' => 6, 'user_id' => 2, 'supplier_id' => 2, 'stok_tanggal' => Carbon::parse('2024-04-02 15:20:00'), 'stok_jumlah' => 45],
            ['stok_id' => 7, 'barang_id' => 7, 'user_id' => 2, 'supplier_id' => 2, 'stok_tanggal' => Carbon::parse('2024-04-02 15:20:00'), 'stok_jumlah' => 40],
            ['stok_id' => 8, 'barang_id' => 8, 'user_id' => 2, 'supplier_id' => 2, 'stok_tanggal' => Carbon::parse('2024-04-02 15:20:00'), 'stok_jumlah' => 35],
            ['stok_id' => 9, 'barang_id' => 9, 'user_id' => 3, 'supplier_id' => 3, 'stok_tanggal' => Carbon::parse('2024-04-02 16:00:00'), 'stok_jumlah' => 30],
            ['stok_id' => 10, 'barang_id' => 10, 'user_id' => 3, 'supplier_id' => 3, 'stok_tanggal' => Carbon::parse('2024-04-02 16:00:00'), 'stok_jumlah' => 25],
        ];
        
        // Insert ke tabel t_stok
        DB::table('t_stok')->insert($data);
    }
}