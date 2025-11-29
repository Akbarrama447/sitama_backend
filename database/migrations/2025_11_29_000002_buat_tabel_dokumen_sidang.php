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
        // Buat tabel dokumen_sidang untuk menyimpan file-file dokumen per syarat sidang
        // Tabel ini akan memiliki relasi ke tabel syarat_sidang yang sudah ada
        Schema::create('dokumen_sidang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('syarat_sidang_id')->constrained('syarat_sidang')->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->string('path_dokumen');
            $table->string('tipe_dokumen')->nullable(); // untuk mengetahui tipe dokumen (PDF, DOCX, dll)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_sidang');
    }
};