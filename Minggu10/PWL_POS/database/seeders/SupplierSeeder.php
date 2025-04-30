<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['supplier_id' => 1, 'supplier_kode' => 'MP', 'supplier_nama' => 'Mentari Pagi', 'supplier_alamat' => 'Surabaya'],
            ['supplier_id' => 2, 'supplier_kode' => 'JM', 'supplier_nama' => 'Jaya Makmur', 'supplier_alamat' => 'Malang'],
            ['supplier_id' => 3, 'supplier_kode' => 'AA', 'supplier_nama' => 'Aman Amin', 'supplier_alamat' => 'Blitar'],
        ];
        
        // Insert ke tabel m_barang
        DB::table('m_supplier')->insert($data);
    }
}