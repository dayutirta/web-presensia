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
            $table->unsignedBigInteger('id_level');

            $table->string('nama_pegawai', 100);
            $table->integer('no_pegawai')->unique();
            $table->unsignedBigInteger('boss')->nullable();
            $table->string('jabatan', 100);
            $table->string('alamat', 255);
            $table->string('nohp', 20);
            $table->string('password');
            $table->string('foto')->nullable();
            $table->boolean('status')->default(false); // Kolom status ditambahkan di sini
            $table->timestamps();

            $table->foreign('id_level')->references('id_level')->on('level')->onDelete('cascade');
            $table->foreign('boss')->references('id_pegawai')->on('pegawai')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};