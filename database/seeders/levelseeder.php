<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class levelseeder extends Seeder
{
    public function run()
    {
        DB::table('level')->insert([
            ['kd_level' => 'HRD', 'nama_level' => 'Human Resource Department', 'created_at' => now(), 'updated_at' => now()],
            ['kd_level' => 'SPV', 'nama_level' => 'Supervisor', 'created_at' => now(), 'updated_at' => now()],
            ['kd_level' => 'EMP', 'nama_level' => 'Employee', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
