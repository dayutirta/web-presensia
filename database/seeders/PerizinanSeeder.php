<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PerizinanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            $tanggal_mulai = $faker->dateTimeThisYear();
            $tanggal_akhir = (clone $tanggal_mulai)->modify('+'. $faker->numberBetween(1, 5) .' days');
            $jenis_izin = $faker->randomElement(['Sakit', 'Cuti', 'WFA']);
            $status_izin = $faker->randomElement(['Disetujui', 'Pending', 'Ditolak']);
            $keterangan = $jenis_izin === 'Sakit' ? 'Sakit ' . $faker->word : ($jenis_izin === 'Cuti' ? 'Liburan' : 'Work From Anywhere');

            DB::table('perizinan')->insert([
                'id_pegawai' => $faker->numberBetween(1, 3), // Mengacu pada pegawai dengan id 1-3
                'jenis_izin' => $jenis_izin,
                'tanggal_mulai' => $tanggal_mulai->format('Y-m-d'),
                'tanggal_akhir' => $tanggal_akhir->format('Y-m-d'),
                'keterangan' => $keterangan,
                'status_izin' => $status_izin,
                'dokumen' => null, // Atau tambahkan logika untuk mengisi dokumen
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}