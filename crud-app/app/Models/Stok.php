<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'stoks'; // Pastikan tabel sesuai dengan nama di database

    protected $fillable = [
        'nama_barang',  // Tambahkan ini
        'jumlah_barang' // Tambahkan ini
    ];
}
