<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('revisi_tugas_akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_akhir_id')->constrained('tugas_akhir')->onDelete('cascade');

            // --- PASTIKAN BAGIAN INI MENGGUNAKAN 'nip' ---
            $table->string('dosen_nip');
            $table->foreign('dosen_nip')
                  ->references('dosen_nip') // Pastikan ini 'nip'
                  ->on('dosen')
                  ->onDelete('cascade');
            // ---------------------------------------------

            $table->text('catatan_revisi');
            $table->string('status_revisi')->default('Belum Selesai'); // Contoh: 'Belum Selesai', 'Disetujui'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisi_tugas_akhir');
    }
};