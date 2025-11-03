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
        Schema::create('tugas_akhir_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_akhir_id')->constrained('tugas_akhir')->onDelete('cascade');
            $table->integer('mhs_nim');
            $table->foreign('mhs_nim')->references('mhs_nim')->on('mahasiswa')->onDelete('cascade');
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
