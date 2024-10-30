<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia

        // Insert 1 HR Manager
        $hrManagerId = DB::table('pegawai')->insertGetId([
            'id_level' => 1, // Level khusus HR Manager
            'nama_pegawai' => 'John Doe',
            'no_pegawai' => 100,
            'jabatan' => 'HR Manager',
            'alamat' => 'Jakarta',
            'nohp' => '081234567890',
            'password' => Hash::make('password'),
            'supervisor' => null, // HR Manager tidak punya supervisor
            'foto' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ], 'id_pegawai'); // specify the primary key column here


        // Insert beberapa Supervisor and store their no_pegawai
        $supervisorNos = [];
        for ($i = 0; $i < 3; $i++) {
            $supervisorNos[] = DB::table('pegawai')->insertGetId([
                'id_level' => 2, // Level supervisor
                'nama_pegawai' => $faker->name,
                'no_pegawai' => $no_pegawai = $faker->unique()->numberBetween(101, 199),
                'jabatan' => 'Supervisor',
                'alamat' => $faker->city,
                'nohp' => $faker->phoneNumber,
                'password' => Hash::make('password'),
                'supervisor' => null, // Supervisor tidak punya supervisor
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ], 'id_pegawai'); // specify the primary key column here            

            $supervisorNos[] = $no_pegawai;
        }

        // Insert beberapa Staff yang memiliki supervisor
        for ($i = 0; $i < 16; $i++) {
            DB::table('pegawai')->insert([
                'id_level' => 3, // Level staff
                'nama_pegawai' => $faker->name,
                'no_pegawai' => $faker->unique()->numberBetween(200, 999),
                'jabatan' => 'Staff',
                'alamat' => $faker->city,
                'nohp' => $faker->phoneNumber,
                'password' => Hash::make('password'),
                'supervisor' => $faker->randomElement($supervisorNos), // berisi no_pegawai
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}