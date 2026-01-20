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
        Schema::table('syarat_sidang', function (Blueprint $table) {
            // Tambah kolom mhs_nim untuk menyimpan informasi siapa yang upload dokumen
            $table->integer('mhs_nim')->nullable()->after('dokumen_id');
            
            // Tambah foreign key constraint
            $table->foreign('mhs_nim')->references('mhs_nim')->on('mahasiswa')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('syarat_sidang', function (Blueprint $table) {
            $table->dropForeign(['mhs_nim']);
            $table->dropColumn('mhs_nim');
        });
    }
};