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
        $today = Carbon::today()->format('Y-m-d'); // Tanggal hari ini

        // Ambil daftar ID pegawai dari database
        $pegawaiIds = DB::table('pegawai')->pluck('id_pegawai');

        foreach ($pegawaiIds as $idPegawai) {
            $status_absen = $faker->randomElement(['Hadir', 'Izin']);
            $waktu_masuk = $status_absen === 'Hadir' ? Carbon::createFromTime($faker->numberBetween(8, 9), $faker->numberBetween(0, 59), 0) : null;
            // Set waktu_keluar menjadi null
            $waktu_keluar = null;
            $id_izin = $status_absen === 'Izin' ? $faker->randomElement([1, 2]) : null; // 1: Sakit, 2: Cuti

            // Insert absensi untuk pegawai
            DB::table('absensi')->insert([
                'id_pegawai' => $idPegawai,
                'id_izin' => $id_izin,
                'tanggal' => $today,
                'waktu_masuk' => $waktu_masuk,
                'waktu_keluar' => $waktu_keluar,  // Nilai waktu_keluar selalu null
                'status_absen' => $status_absen,
                'foto_absen' => null, // Bisa tambahkan logika untuk foto jika diperlukan
                'lokasi_absen' => $faker->city,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
