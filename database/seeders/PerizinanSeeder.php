<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerizinanSeeder extends Seeder
{
    public function run()
    {
        DB::table('perizinan')->insert([
            [
                'id_pegawai' => 1,
                'jenis_izin' => 'Sakit',
                'tanggal_mulai' => '2024-10-01',
                'tanggal_akhir' => '2024-10-02',
                'keterangan' => 'Flu berat',
                'status_izin' => 'Disetujui',
                'dokumen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pegawai' => 2,
                'jenis_izin' => 'Cuti',
                'tanggal_mulai' => '2024-10-05',
                'tanggal_akhir' => '2024-10-07',
                'keterangan' => 'Liburan keluarga',
                'status_izin' => 'Disetujui',
                'dokumen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pegawai' => 3,
                'jenis_izin' => 'WFH',
                'tanggal_mulai' => '2024-10-10',
                'tanggal_akhir' => '2024-10-10',
                'keterangan' => 'Work From Home',
                'status_izin' => 'Disetujui',
                'dokumen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
