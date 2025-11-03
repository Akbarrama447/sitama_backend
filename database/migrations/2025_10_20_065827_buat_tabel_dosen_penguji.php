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
        Schema::create('dosen_penguji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sidang_id')->constrained('sidang_Tugas_Akhir')->onDelete('cascade');
            $table->string('dosen_nip');
            $table->foreign('dosen_nip')->references('dosen_nip')->on('dosen')->onDelete('cascade');
            $table->string('peran', 50); // Contoh: "Ketua Penguji", "Anggota Penguji"
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
