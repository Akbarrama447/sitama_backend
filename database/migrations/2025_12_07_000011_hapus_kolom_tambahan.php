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
        if (Schema::hasTable('syarat_sidang')) {
            Schema::table('syarat_sidang', function (Blueprint $table) {
                // Drop foreign key terlebih dahulu jika ada
                try {
                    $table->dropForeign(['verifikator_id']);
                } catch (\Exception $e) {
                    // Jika foreign key tidak ada, lanjutkan tanpa error
                }

                // Hapus kolom-kolom yang tidak diperlukan
                $table->dropColumn([
                    'tanggal_upload',
                    'verifikator_id',
                    'tanggal_verifikasi',
                    'komentar_verifikasi',
                    'status_verifikasi'
                ]);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('syarat_sidang')) {
            Schema::table('syarat_sidang', function (Blueprint $table) {
                $table->timestamp('tanggal_upload')->nullable();
                $table->unsignedBigInteger('verifikator_id')->nullable();
                $table->timestamp('tanggal_verifikasi')->nullable();
                $table->text('komentar_verifikasi')->nullable();
                $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
                
                $table->foreign('verifikator_id')->references('id')->on('user')->onDelete('set null');
            });
        }
    }
};