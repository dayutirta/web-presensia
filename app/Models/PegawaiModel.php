<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PegawaiModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $primaryKey = 'id_pegawai';

    protected $guarded = [
        'id_pegawai',
        'id_level',
    ];

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }
}
