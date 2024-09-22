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
        Schema::connection('mysql_ga')->create('pengajuan_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pengajuan_fasilitas'); // Jenis Pengajuan Fasilitas
            $table->unsignedBigInteger('nik'); // NIK
            $table->string('name'); // Name
            $table->string('dept'); // Dept
            $table->string('jenis_fasilitas'); // Jenis Fasilitas
            $table->string('nomor_identitas_fasilitas')->nullable(); // Nomor Identitas Fasilitas (Optional)
            $table->string('foto_fasilitas'); // Foto Fasilitas
            $table->string('foto_lokasi_fasilitas'); // Foto Lokasi Fasilitas
            $table->string('lokasi'); // Lokasi
            $table->string('alasan_pengajuan'); // Alasan Permintaan/Pergantian Fasilitas
            $table->date('due_date'); // DUE DATE
            $table->string('remarks')->nullable(); // Remaks
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_fasilitas');
    }
};
