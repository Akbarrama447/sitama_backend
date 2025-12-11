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
        // Kita akan drop tabel jika ada dan buat ulang sesuai struktur PM
        Schema::dropIfExists('dokumen_sidang');
        Schema::dropIfExists('syarat_sidang');
        
        // Buat tabel dokumen_sidang sesuai struktur PM
        Schema::create('dokumen_sidang', function (Blueprint $table) {
            $table->id('dokumen_id'); // primary key dengan nama dokumen_id
            $table->string('dokumen_syarat', 50)->nullable();
            $table->string('dokumen_file', 100)->nullable();
            $table->boolean('verified')->default(false);
        });
        
        // Buat tabel syarat_sidang sesuai struktur PM
        Schema::create('syarat_sidang', function (Blueprint $table) {
            $table->id('id'); // primary key dengan nama id
            $table->unsignedBigInteger('tugas_akhir_id');
            $table->unsignedBigInteger('dokumen_id');
            $table->string('dokumen_file_original', 255);
            $table->string('dokumen_file', 255);
            $table->integer('verified')->default(0);
            
            // Tambahkan foreign key
            $table->foreign('tugas_akhir_id')->references('id')->on('tugas_akhir')->onDelete('cascade');
            $table->foreign('dokumen_id')->references('dokumen_id')->on('dokumen_sidang')->onDelete('cascade');
        });
        
        // Baru tambahkan kolom-kolom baru
        Schema::table('dokumen_sidang', function (Blueprint $table) {
            // Kolom tambahan untuk deskripsi dan keterangan dokumen
            $table->text('keterangan')->nullable();
            $table->boolean('wajib')->default(true); // true = wajib, false = opsional
            $table->string('tipe_dokumen', 50)->nullable(); // pdf, doc, docx, dll
        });
        
        Schema::table('syarat_sidang', function (Blueprint $table) {
            // Kolom untuk user yang upload
            $table->unsignedBigInteger('user_id')->nullable();
            
            // Kolom untuk tanggal upload
            $table->timestamp('tanggal_upload')->nullable();
            
            // Kolom untuk user yang verifikasi
            $table->unsignedBigInteger('verifikator_id')->nullable();
            
            // Kolom untuk tanggal verifikasi
            $table->timestamp('tanggal_verifikasi')->nullable();
            
            // Kolom untuk komentar verifikasi
            $table->text('komentar_verifikasi')->nullable();
            
            // Kolom status verifikasi yang lebih spesifik
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Foreign key untuk user yang upload
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_sidang');
        Schema::dropIfExists('dokumen_sidang');
    }
};