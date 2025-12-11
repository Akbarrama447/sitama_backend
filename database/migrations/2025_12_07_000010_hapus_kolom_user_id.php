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
        if (Schema::hasTable('syarat_sidang') && Schema::hasColumn('syarat_sidang', 'user_id')) {
            Schema::table('syarat_sidang', function (Blueprint $table) {
                // Drop foreign key terlebih dahulu sebelum menghapus kolom
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // Jika foreign key tidak ada, lanjutkan
                }
                
                $table->dropColumn('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('syarat_sidang') && !Schema::hasColumn('syarat_sidang', 'user_id')) {
            Schema::table('syarat_sidang', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
            });
        }
    }
};