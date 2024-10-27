<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbsensiSeeder extends Seeder
{
    public function run()
    {
        DB::table('absensi')->insert([
            [
                'id_pegawai' => 1, // John Doe
                'id_izin' => null, // Hadir tanpa izin
                'tanggal' => '2024-10-26',
                'waktu_masuk' => Carbon::parse('2024-10-26 08:00:00'),
                'waktu_keluar' => Carbon::parse('2024-10-26 17:00:00'),
                'status_absen' => 'Hadir',
                'foto_absen' => null,
                'lokasi_absen' => 'Jakarta',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_pegawai' => 2, // Jane Smith
                'id_izin' => 1, // Sakit
                'tanggal' => '2024-10-01',
                'waktu_masuk' => null,
                'waktu_keluar' => null,
                'status_absen' => 'Izin',
                'foto_absen' => null,
                'lokasi_absen' => 'Bandung',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_pegawai' => 3, // Alice Johnson
                'id_izin' => 2, // Cuti
                'tanggal' => '2024-10-05',
                'waktu_masuk' => null,
                'waktu_keluar' => null,
                'status_absen' => 'Izin',
                'foto_absen' => null,
                'lokasi_absen' => 'Surabaya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_pegawai' => 3, // Alice Johnson
                'id_izin' => null, // Hadir tanpa izin
                'tanggal' => '2024-10-11',
                'waktu_masuk' => Carbon::parse('2024-10-11 09:00:00'),
                'waktu_keluar' => Carbon::parse('2024-10-11 18:00:00'),
                'status_absen' => 'Hadir',
                'foto_absen' => null,
                'lokasi_absen' => 'Surabaya',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
