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
        'id_perizinan',
        'id_pegawai',
    ];

    public function bansos()
    {
        return $this->belongsTo(PegawaiModel::class, 'id_pegawai', 'id_pegawai');
    }
    public function user()
    {
        return $this->belongsTo(PerizinanModel::class, 'id_perizinan', 'id_perizinan');
    }
}
