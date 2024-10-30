<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class AbsensiSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 20; $i++) {
            $status_absen = $faker->randomElement(['Hadir', 'Izin']);
            $waktu_masuk = $status_absen === 'Hadir' ? Carbon::parse($faker->dateTimeBetween('08:00', '09:00')->format('Y-m-d H:i:s')) : null;
            $waktu_keluar = $status_absen === 'Hadir' ? Carbon::parse($faker->dateTimeBetween('17:00', '18:00')->format('Y-m-d H:i:s')) : null;
            $id_izin = $status_absen === 'Izin' ? $faker->randomElement([1, 2]) : null; // 1: Sakit, 2: Cuti

            DB::table('absensi')->insert([
                'id_pegawai' => $faker->numberBetween(1, 3), // Angka pegawai antara 1-3
                'id_izin' => $id_izin,
                'tanggal' => $faker->dateTimeThisMonth()->format('Y-m-d'),
                'waktu_masuk' => $waktu_masuk,
                'waktu_keluar' => $waktu_keluar,
                'status_absen' => $status_absen,
                'foto_absen' => null, // Bisa tambahkan logika untuk foto jika diperlukan
                'lokasi_absen' => $faker->city,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}