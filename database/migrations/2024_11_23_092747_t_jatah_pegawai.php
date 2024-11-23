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
        Schema::create('jatah_pegawai', function (Blueprint $table) {
            $table->id('id_jatah');
            $table->unsignedBigInteger('id_pegawai');

            $table->integer('jatah_wfa')->default(12);
            $table->integer('jatah_cuti')->default(12);
            $table->integer('sisa_wfa')->default(12);
            $table->integer('sisa_cuti')->default(12);
            $table->year('tahun');

            $table->timestamps();

            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jatah_pegawai');
    }
};
