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

        if (!Schema::hasTable('bimbingan')) {
        Schema::table('bimbingan', function (Blueprint $table) {
            // Add necessary columns to bimbingan table
            $table->foreignId('tugas_akhir_id')->nullable()->constrained('tugas_akhir', 'id')->onDelete('cascade');
            $table->string('dosen_nip')->nullable();
            $table->integer('urutan')->nullable(); // 1 for pembimbing 1, 2 for pembimbing 2
            
            // Add foreign key constraint for dosen_nip
            $table->foreign('dosen_nip')->references('dosen_nip')->on('dosen')->onDelete('cascade');
            
            // Add unique constraint to prevent duplicate pembimbing assignment
            $table->unique(['tugas_akhir_id', 'dosen_nip'], 'unique_bimbingan_dosen');
        });
    }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bimbingan', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['tugas_akhir_id']);
            $table->dropForeign(['dosen_nip']);
            
            // Drop unique constraint
            $table->dropUnique('unique_bimbingan_dosen');
            
            // Drop columns
            $table->dropColumn(['tugas_akhir_id', 'dosen_nip', 'urutan']);
        });
    }
};