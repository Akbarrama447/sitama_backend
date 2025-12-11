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
        if (Schema::hasTable('dokumen_sidang') && Schema::hasColumn('dokumen_sidang', 'wajib')) {
            Schema::table('dokumen_sidang', function (Blueprint $table) {
                $table->dropColumn('wajib');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('dokumen_sidang') && !Schema::hasColumn('dokumen_sidang', 'wajib')) {
            Schema::table('dokumen_sidang', function (Blueprint $table) {
                $table->boolean('wajib')->default(true); // Jika direstore, default true karena semua dokumen wajib
            });
        }
    }
};