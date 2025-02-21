<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'stoks'; //Menentukan nama tabel yang digunakan model ini

    //Menentukan atribut yang dapat diisi secara massal
    protected $fillable = [
        'nama_barang',  
        'jumlah_barang' 
    ];
}
