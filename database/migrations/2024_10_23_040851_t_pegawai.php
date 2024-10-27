<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->unsignedBigInteger('id_level'); // Tipe data foreign key

            $table->string('nama_pegawai', 100);
            $table->integer('no_pegawai');
            $table->string('jabatan', 100);
            $table->string('alamat', 255);
            $table->string('nohp', 15);
            $table->string('password');
            $table->binary('foto')->nullable(); // Menyimpan foto dalam format bytea
            $table->timestamps(); // created_at & updated_at

            // Definisi foreign key
            $table->foreign('id_level')->references('id_level')->on('level')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
