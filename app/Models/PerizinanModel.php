<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanModel extends Model
{
    use HasFactory;

    protected $table = 'perizinan';
    protected $primaryKey = 'id_izin';

    // Remove 'id_pegawai' from $guarded
    protected $guarded = [
        'id_izin', // You can keep other fields in $guarded like this
    ];

    public function bantuan()
    {
        return $this->belongsTo(PegawaiModel::class, 'id_pegawai', 'id_pegawai');
    }
}

