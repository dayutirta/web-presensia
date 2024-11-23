<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class PegawaiModel extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $guarded = [
        'id_pegawai'
    ];

    // protected $fillable = [
    //     'nama_pegawai',
    //     'no_pegawai',
    //     'boss',
    //     'jabatan',
    //     'alamat',
    //     'nohp',
    //     'password',
    //     'id_level',
    //     'foto'
    // ];

    protected $hidden = [
        'password',
    ];

    // Relasi yang sudah ada
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }

    public function bawahan()
    {
        return $this->hasMany(PegawaiModel::class, 'boss', 'id_pegawai');
    }

    // Method untuk JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function jatah()
    {
        return $this->hasOne(JatahPegawaiModel::class, 'id_pegawai', 'id_pegawai');
    }

    // Override method untuk authentication menggunakan no_pegawai
    // public function username()
    // {
    //     return 'no_pegawai';
    // }

    // Optional: custom method untuk mencari pegawai berdasarkan no_pegawai
    // public function findForPassport($username)
    // {
    //     return $this->where('no_pegawai', $username)->first();
    // }

    // // Optional: Accessor untuk memastikan password selalu di-hash
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }
}
