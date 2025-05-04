<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'kategori_kode' => 'PKI', 'kategori_nama' => 'Pakaian'],
            ['kategori_id' => 2, 'kategori_kode' => 'ELTR', 'kategori_nama' => 'Elektronik'],
            ['kategori_id' => 3, 'kategori_kode' => 'MKN', 'kategori_nama' => 'Makanan'],
            ['kategori_id' => 4, 'kategori_kode' => 'MNM', 'kategori_nama' => 'Minuman'],
            ['kategori_id' => 5, 'kategori_kode' => 'PRBT', 'kategori_nama' => 'Perabotan'],
        ];
        
        // Insert ke tabel m_kategori
        DB::table('m_kategori')->insert($data);
    }
}