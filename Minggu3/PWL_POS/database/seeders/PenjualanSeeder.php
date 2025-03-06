<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 1, 'pembeli' => 'Annisa', 'penjualan_kode' => 'PJL001', 'penjualan_tanggal' => '2025-01-03 12:25:00'],
            ['penjualan_id' => 2, 'user_id' => 1, 'pembeli' => 'Eka', 'penjualan_kode' => 'PJL002', 'penjualan_tanggal' => '2025-01-07 09:30:00'],
            ['penjualan_id' => 3, 'user_id' => 1, 'pembeli' => 'Puspita', 'penjualan_kode' => 'PJL003', 'penjualan_tanggal' => '2025-01-10 14:45:00'],
            ['penjualan_id' => 4, 'user_id' => 1, 'pembeli' => 'Ninis', 'penjualan_kode' => 'PJL004', 'penjualan_tanggal' => '2025-01-11 10:00:00'],
            ['penjualan_id' => 5, 'user_id' => 1, 'pembeli' => 'Nisa', 'penjualan_kode' => 'PJL005', 'penjualan_tanggal' => '2025-01-12 13:20:00'],
            ['penjualan_id' => 6, 'user_id' => 1, 'pembeli' => 'Pita', 'penjualan_kode' => 'PJL006', 'penjualan_tanggal' => '2025-01-14 16:50:00'],
            ['penjualan_id' => 7, 'user_id' => 1, 'pembeli' => 'Ani', 'penjualan_kode' => 'PJL007', 'penjualan_tanggal' => '2025-01-17 10:40:00'],
            ['penjualan_id' => 8, 'user_id' => 1, 'pembeli' => 'Annisa Eka', 'penjualan_kode' => 'PJL008', 'penjualan_tanggal' => '2025-01-20 13:50:00'],
            ['penjualan_id' => 9, 'user_id' => 1, 'pembeli' => 'Eka Puspita', 'penjualan_kode' => 'PJL009', 'penjualan_tanggal' => '2025-01-24 15:35:00'],
            ['penjualan_id' => 10, 'user_id' => 1, 'pembeli' => 'Puspi', 'penjualan_kode' => 'PJL010', 'penjualan_tanggal' => '2025-01-29 17:25:00'],
        ];
        
        // Insert data ke tabel t_penjualan
        DB::table('t_penjualan')->insert($data);
    }
}
