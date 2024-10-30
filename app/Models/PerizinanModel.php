<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanModel extends Model
{
    use HasFactory;

    protected $table = 'perizinan';
    protected $primaryKey = 'id_perizinan';

    protected $guarded = [
        'id_pegawai',
        'id_perizinan',
    ];

    public function bantuan()
    {
        return $this->belongsTo(PegawaiModel::class, 'id_pegawai', 'id_pegawai');
    }
}
