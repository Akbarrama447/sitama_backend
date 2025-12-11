<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus tabel dokumen_sidang yang baru
        Schema::dropIfExists('dokumen_sidang');
        
        // Rename old_dokumen_sidang menjadi dokumen_sidang jika ada
        if (Schema::hasTable('old_dokumen_sidang')) {
            DB::statement('RENAME TABLE old_dokumen_sidang TO dokumen_sidang');
        }
        
        // Jika tidak ada old_dokumen_sidang, buat tabel dokumen_sidang seperti semula
        if (!Schema::hasTable('dokumen_sidang')) {
            Schema::create('dokumen_sidang', function (Blueprint $table) {
                $table->id();
                $table->foreignId('syarat_sidang_id')->constrained('syarat_sidang')->onDelete('cascade');
                $table->string('nama_dokumen');
                $table->string('path_dokumen');
                $table->string('tipe_dokumen')->nullable();
                $table->timestamps();
            });
        }
        
        // Jika tidak ada tabel syarat_sidang, buat seperti semula
        if (!Schema::hasTable('syarat_sidang')) {
            Schema::create('syarat_sidang', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tugas_akhir_id')->constrained('tugas_akhir')->onDelete('cascade');
                $table->string('nama_syarat');
                $table->string('file_path');
                $table->string('status', 50);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu rollback, karena ini hanya untuk kembali ke kondisi awal
    }
};