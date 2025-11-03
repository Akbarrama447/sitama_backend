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
        Schema::create('bimbingan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_akhir_id')->constrained('tugas_akhir')->onDelete('cascade');
            $table->string('dosen_nip', 20);
            $table->foreign('dosen_nip')->references('dosen_nip')->on('dosen')->onDelete('cascade');
            $table->tinyInteger('urutan')->comment('urutan pembimbing'); // Contoh: 1 atau 2
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
