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
        Schema::create('perizinan', function (Blueprint $table) {
            $table->id('id_izin');
            $table->unsignedBigInteger('id_pegawai'); // Tipe data foreign key

            $table->string('jenis_izin', 50);
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->text('keterangan');
            $table->string('status_izin', 50);
            $table->string('dokumen')->nullable(); // Menyimpan dokumen izin dalam format bytea
            $table->timestamps(); // created_at & updated_at

            // Definisi foreign key
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinan');
    }
};