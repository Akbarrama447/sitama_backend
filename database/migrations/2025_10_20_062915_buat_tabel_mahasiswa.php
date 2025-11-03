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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->integer('mhs_nim')->primary();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->foreignId('prodi_id')->constrained('prodi');
            $table->string('mhs_nama');
            $table->year('tahun_masuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
