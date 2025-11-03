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
        Schema::create('sidang_Tugas_Akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_akhir_id')->constrained('tugas_akhir')->onDelete('cascade');
            $table->foreignId('jadwal_sidang_id')->constrained('jadwal_sidang')->onDelete('cascade');
            $table->string('status', 50); // Contoh: "Lulus", "Lulus dengan Revisi", "Tidak Lulus"
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
