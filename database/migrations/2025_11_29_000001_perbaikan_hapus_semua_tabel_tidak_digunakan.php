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
        // Hapus tabel file_dokumen_sidang jika ada
        if (Schema::hasTable('file_dokumen_sidang')) {
            Schema::dropIfExists('file_dokumen_sidang');
        }

        // Hapus tabel dokumen_sidang jika ada (dari percobaan sebelumnya)
        if (Schema::hasTable('dokumen_sidang')) {
            Schema::dropIfExists('dokumen_sidang');
        }

        // Hapus record migration yang berkaitan dengan tabel-tabel ini dari tabel migrations
        DB::table('migrations')
          ->where('migration', 'like', '%buat_tabel_file_dokumen_sidang%')
          ->orWhere('migration', 'like', '%modifikasi_tabel_syarat_sidang%')
          ->orWhere('migration', 'like', '%perbaikan_struktur_syarat_sidang%')
          ->orWhere('migration', 'like', '%buat_tabel_dokumen_sidang%')
          ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak ada yang dikembalikan karena ini hanya untuk membersihkan
    }
};