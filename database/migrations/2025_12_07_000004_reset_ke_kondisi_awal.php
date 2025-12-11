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
        // Hapus tabel dokumen_sidang yang sekarang (jika ada)
        Schema::dropIfExists('dokumen_sidang');
        
        // Hapus tabel syarat_sidang jika ada
        Schema::dropIfExists('syarat_sidang');
        
        // Buat tabel syarat_sidang dengan struktur awal
        Schema::create('syarat_sidang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_akhir_id')->constrained('tugas_akhir')->onDelete('cascade');
            $table->string('nama_syarat');
            $table->string('file_path');
            $table->string('status', 50);
            $table->timestamps();
        });
        
        // Buat tabel dokumen_sidang dengan struktur awal
        Schema::create('dokumen_sidang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('syarat_sidang_id')->constrained('syarat_sidang')->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->string('path_dokumen');
            $table->string('tipe_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus tabel yang dibuat
        Schema::dropIfExists('dokumen_sidang');
        Schema::dropIfExists('syarat_sidang');
    }
};