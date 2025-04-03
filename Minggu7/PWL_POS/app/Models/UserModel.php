<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // Implementasi class Authenticatable

// ------------------------ 
// JOBSHEET 7
// ------------------------

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['username', 'password', 'nama', 'level_id', 'created_at', 'updated_at'];

    protected $hidden = ['password']; // jangan di tampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash

    /**
     * Relasi ke tabel level
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}



// ------------------------ 
// JOBSHEET 4
// ------------------------

// class UserModel extends Model
// {

//     // public function level(): HasOne
//     // {
//     //     return $this->hasOne(LevelModel::class);
//     // }

//     use HasFactory;

//     protected $table = 'm_user';      // Mendefinisikan nama tabel yang digunakan oleh model ini
//     protected $primaryKey = 'user_id';  // Mendefinisikan primary key dari tabel yang digunakan
//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array
//      */
//     protected $fillable = ['level_id', 'username', 'nama', 'password'];
//     //protected $fillable = ['level_id', 'username', 'nama'];

//     //PRAKTIKUM 2.7 - ONE TO ONE
//     public function level(): BelongsTo
//     {
//         return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
//     }

// }
