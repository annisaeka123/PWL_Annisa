<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Model
{
    
    //JOBSHEET 4

    // public function level(): HasOne
    // {
    //     return $this->hasOne(LevelModel::class);
    // }

    use HasFactory;

    protected $table = 'm_user';      // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id';  // Mendefinisikan primary key dari tabel yang digunakan
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['level_id', 'username', 'nama', 'password'];
    //protected $fillable = ['level_id', 'username', 'nama'];

    //PRAKTIKUM 2.7 - ONE TO ONE
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

}
