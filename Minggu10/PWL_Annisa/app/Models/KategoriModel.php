<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriModel extends Model
{
    // Tentukan nama tabel jika berbeda dari default
    protected $table = 'm_kategori';  // Jika tabelnya bernama 'm_kategori'

    protected $primaryKey = 'kategori_id';  
    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = ['kategori_kode', 'kategori_nama'];

    // Relasi one-to-many dengan BarangModel
    public function barang(): HasMany
    {
        // BarangModel memiliki kolom 'kategori_id' sebagai foreign key
        return $this->hasMany(BarangModel::class, 'kategori_id', 'kategori_id');
    }
}
