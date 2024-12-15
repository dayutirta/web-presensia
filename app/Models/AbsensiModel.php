<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AbsensiModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'absensi';

    protected $primaryKey = 'id_absensi';

    protected $guarded = [
        'id_absensi',
    ];
    public function izin()
    {
        return $this->belongsTo(PerizinanModel::class, 'id_izin', 'id_izin');
    }
    public function pegawai()
    {
        return $this->belongsTo(PegawaiModel::class, 'id_pegawai', 'id_pegawai');
    }
}