<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('id_absen');
            $table->unsignedBigInteger('id_pegawai'); // Tipe data foreign key
            $table->unsignedBigInteger('id_izin')->nullable(); // Tipe data foreign key, nullable

            $table->date('tanggal');
            $table->timestamp('waktu_masuk')->nullable();
            $table->timestamp('waktu_keluar')->nullable();
            $table->string('status_absen', 50);
            $table->binary('foto_absen')->nullable();
            $table->string('lokasi_absen', length: 100);

            $table->timestamps(); // created_at & updated_at

            // Definisi foreign key
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawai')->onDelete('cascade');
            $table->foreign('id_izin')->references('id_izin')->on('perizinan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};