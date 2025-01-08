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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('pendaftaran_id');
            $table->string('nama_pasien');
            $table->string('keluhan_pasien');
            $table->string('alamat_pasien');
            $table->boolean('status_pasien');
            $table->string('no_telp_pasien');
            $table->boolean('is_pasien_sendiri');
            $table->string('jumlah_pasien_lain')->nullable();
            $table->string('nomor_antrian')->nullable();
            $table->string('status_periksa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
