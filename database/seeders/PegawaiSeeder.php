<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        DB::table('pegawai')->insert([
            [
                'id_level' => 1,
                'nama_pegawai' => 'John Doe',
                'no_pegawai' => 100,
                'jabatan' => 'HR Manager',
                'alamat' => 'Jakarta',
                'nohp' => '081234567890',
                'password' => Hash::make('123'),
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_level' => 2,
                'nama_pegawai' => 'Jane Smith',
                'no_pegawai' => 101,
                'jabatan' => 'Supervisor',
                'alamat' => 'Bandung',
                'nohp' => '081234567891',
                'password' => Hash::make('111'),
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_level' => 3,
                'nama_pegawai' => 'Alice Johnson',
                'no_pegawai' => 102,
                'jabatan' => 'Staff',
                'alamat' => 'Surabaya',
                'nohp' => '081234567892',
                'password' => Hash::make('222'),
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
