<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_nilai_table.php

        public function up(): void
        {
            Schema::create('nilai', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sidang_id')->constrained('sidang')->onDelete('cascade');
                $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade'); // Dosen yg memberi nilai
                $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade'); // Mahasiswa yg dinilai
                $table->foreignId('unsur_nilai_id')->constrained('unsur_nilai')->onDelete('cascade');
                $table->float('nilai_angka');
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
