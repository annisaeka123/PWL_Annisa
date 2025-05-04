<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable implements JWTSubject
{

    // JOBSHEET 11 =================

        public function getJWTIdentifier() {
            return $this->getKey();
        }

        public function getJWTCustomClaims() {
            return [];
        }

        protected $table = 'm_user';
        protected $primaryKey = 'user_id';

        protected $fillable = [
            'username',
            'nama',
            'password',
            'level_id',
            'image' //tambahan
        ];

        public function level()
        {
            return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
        }

        protected function image(): Attribute
        {
            return Attribute::make(
                get: fn ($image) => url('/storage/posts/' . $image),
            );
        }

    // =============================

    /**
     * Mendapatkan nama role
     */
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    /**
     * Mendapatkan kode role
     */
    public function getRole()
    {
        return $this->level->level_kode;
    }

}

    // JOBSHEET 10 =================

    // // Praktikum 1
    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }

    // protected $table = 'm_user';
    // protected $primaryKey = 'user_id';

    // // =================================

    // protected $fillable = ['username', 'password', 'nama', 'level_id', 'level_nama', 'created_at', 'updated_at'];

    // protected $hidden = ['password']; // jangan di tampilkan saat select

    // protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash

    // /**
    //  * Relasi ke tabel level
    //  */
    // public function level(): BelongsTo
    // {
    //     return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    // }