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
        Schema::table('revisi_tugas_akhir', function (Blueprint $table) {
            $table->string('file_revisi')->nullable()->after('catatan_revisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revisi_tugas_akhir', function (Blueprint $table) {
            $table->dropColumn('file_revisi');
        });
    }
};