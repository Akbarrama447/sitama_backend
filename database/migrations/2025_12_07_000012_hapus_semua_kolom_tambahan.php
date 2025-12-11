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
        if (Schema::hasTable('syarat_sidang')) {
            Schema::table('syarat_sidang', function (Blueprint $table) {
                // Hapus kolom-kolom tambahan satu per satu
                $columns = [
                    'tanggal_upload',
                    'verifikator_id', 
                    'tanggal_verifikasi', 
                    'komentar_verifikasi', 
                    'status_verifikasi',
                    'user_id'
                ];
                
                foreach ($columns as $column) {
                    if (Schema::hasColumn('syarat_sidang', $column)) {
                        try {
                            // Jika kolom memiliki foreign key, hapus dulu
                            if ($column === 'user_id' || $column === 'verifikator_id') {
                                try {
                                    $table->dropForeign([$column]);
                                } catch (\Exception $e) {
                                    // Jika foreign key tidak ada, lanjutkan
                                }
                            }
                            $table->dropColumn($column);
                        } catch (\Exception $e) {
                            // Jika terjadi error saat menghapus kolom, lanjutkan
                        }
                    }
                }
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
                $table->unsignedBigInteger('user_id')->nullable();
                
                $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
                $table->foreign('verifikator_id')->references('id')->on('user')->onDelete('set null');
            });
        }
    }
};