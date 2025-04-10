<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 3, 'pembeli' => 'Ghetsa', 'penjualan_kode' => 'PJL1', 'penjualan_tanggal' => Carbon::parse('2024-05-02 14:20:00')],
            ['penjualan_id' => 2, 'user_id' => 3, 'pembeli' => 'Oltha', 'penjualan_kode' => 'PJL2', 'penjualan_tanggal' => Carbon::parse('2024-05-02 14:20:00')],
            ['penjualan_id' => 3, 'user_id' => 3, 'pembeli' => 'Reika', 'penjualan_kode' => 'PJL3', 'penjualan_tanggal' => Carbon::parse('2024-05-02 14:20:00')],
            ['penjualan_id' => 4, 'user_id' => 3, 'pembeli' => 'Neva', 'penjualan_kode' => 'PJL4', 'penjualan_tanggal' => Carbon::parse('2024-05-02 14:20:00')],
            ['penjualan_id' => 5, 'user_id' => 3, 'pembeli' => 'Vanes', 'penjualan_kode' => 'PJL5', 'penjualan_tanggal' => Carbon::parse('2024-05-02 14:20:00')],
            
        ];
        
        // Insert ke tabel t_penjualan
        DB::table('t_penjualan')->insert($data);
    }
}