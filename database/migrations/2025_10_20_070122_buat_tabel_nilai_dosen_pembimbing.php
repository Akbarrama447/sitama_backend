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
        Schema::create('nilai_dosen_pembimbing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sidang_id')->constrained('sidang_Tugas_Akhir')->onDelete('cascade');
            $table->string('dosen_nip');
            $table->foreign('dosen_nip')->references('dosen_nip')->on('dosen')->onDelete('cascade');
            $table->foreignId('unsur_id')->constrained('unsur_nilai_pembimbing');
            $table->integer('nilai');
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
