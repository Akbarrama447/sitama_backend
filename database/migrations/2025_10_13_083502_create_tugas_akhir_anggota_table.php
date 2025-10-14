<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_tugas_akhir_anggota_table.php

        public function up(): void
        {
            Schema::create('tugas_akhir_anggota', function (Blueprint $table) {
                $table->foreignId('tugas_akhir_id')->constrained('tugas_akhir')->onDelete('cascade');
                $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
                
                // Primary key gabungan untuk memastikan mahasiswa tidak bisa didaftarkan
                // ke TA yang sama lebih dari sekali.
                $table->primary(['tugas_akhir_id', 'mahasiswa_id']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_akhir_anggota');
    }
};
