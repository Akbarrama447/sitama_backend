<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menambah kolom-kolom baru ke tabel yang sudah ada sesuai struktur PM

        // Tambah kolom ke tabel dokumen_sidang
        if (Schema::hasTable('dokumen_sidang')) {
            Schema::table('dokumen_sidang', function (Blueprint $table) {
                // Kolom tambahan untuk deskripsi dan keterangan dokumen
                if (!Schema::hasColumn('dokumen_sidang', 'keterangan')) {
                    $table->text('keterangan')->nullable();
                }
                
                if (!Schema::hasColumn('dokumen_sidang', 'wajib')) {
                    $table->boolean('wajib')->default(true); // true = wajib, false = opsional
                }
                
                if (!Schema::hasColumn('dokumen_sidang', 'tipe_dokumen')) {
                    $table->string('tipe_dokumen', 50)->nullable(); // pdf, doc, docx, dll
                }
            });
        }
        
        // Tambah kolom-kolom baru ke tabel syarat_sidang
        if (Schema::hasTable('syarat_sidang')) {
            Schema::table('syarat_sidang', function (Blueprint $table) {
                // Kolom untuk user yang upload
                if (!Schema::hasColumn('syarat_sidang', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable();
                }
                
                // Kolom untuk tanggal upload
                if (!Schema::hasColumn('syarat_sidang', 'tanggal_upload')) {
                    $table->timestamp('tanggal_upload')->nullable();
                }
                
                // Kolom untuk user yang verifikasi
                if (!Schema::hasColumn('syarat_sidang', 'verifikator_id')) {
                    $table->unsignedBigInteger('verifikator_id')->nullable();
                }
                
                // Kolom untuk tanggal verifikasi
                if (!Schema::hasColumn('syarat_sidang', 'tanggal_verifikasi')) {
                    $table->timestamp('tanggal_verifikasi')->nullable();
                }
                
                // Kolom untuk komentar verifikasi
                if (!Schema::hasColumn('syarat_sidang', 'komentar_verifikasi')) {
                    $table->text('komentar_verifikasi')->nullable();
                }
                
                // Kolom status verifikasi yang lebih spesifik
                if (!Schema::hasColumn('syarat_sidang', 'status_verifikasi')) {
                    $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
                }
            });
        }
        
        // Tambah foreign key di luar closure karena harus setelah kolom benar-benar dibuat
        if (Schema::hasTable('syarat_sidang') && Schema::hasColumn('syarat_sidang', 'user_id')) {
            // Cek apakah foreign key sudah ada sebelum menambahkannya
            $foreignKeyExists = false;
            try {
                $result = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'syarat_sidang' 
                    AND COLUMN_NAME = 'user_id'
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");
                $foreignKeyExists = count($result) > 0;
            } catch (\Exception $e) {
                // Jika terjadi error dalam pengecekan, asumsikan foreign key belum ada
            }
            
            if (!$foreignKeyExists) {
                Schema::table('syarat_sidang', function (Blueprint $table) {
                    $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom-kolom yang ditambahkan
        if (Schema::hasTable('dokumen_sidang')) {
            Schema::table('dokumen_sidang', function (Blueprint $table) {
                $table->dropColumn(['keterangan', 'wajib', 'tipe_dokumen']);
            });
        }

        if (Schema::hasTable('syarat_sidang')) {
            Schema::table('syarat_sidang', function (Blueprint $table) {
                // Drop foreign key terlebih dahulu sebelum menghapus kolom
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // Jika foreign key tidak ada, lanjutkan
                }
                
                $table->dropColumn([
                    'user_id', 'tanggal_upload', 'verifikator_id', 
                    'tanggal_verifikasi', 'komentar_verifikasi', 'status_verifikasi'
                ]);
            });
        }
    }
};