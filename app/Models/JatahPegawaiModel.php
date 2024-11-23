<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JatahPegawaiModel extends Model
{
    use HasFactory;

    protected $table = 'jatah_pegawai';
    protected $primaryKey = 'id_jatah';
    protected $fillable = [
        'id_pegawai',
        'jatah_wfa',
        'jatah_cuti',
        'sisa_wfa',
        'sisa_cuti',
        'tahun',
    ];

    // Relasi ke tabel Pegawai
    public function pegawai()
    {
        return $this->belongsTo(PegawaiModel::class, 'id_pegawai', 'id_pegawai');
    }
}
