<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_sidang_table.php

        public function up(): void
        {
            Schema::create('sidang', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tugas_akhir_id')->constrained('tugas_akhir')->onDelete('cascade');
                $table->date('tanggal_sidang');
                $table->time('waktu_mulai');
                $table->time('waktu_selesai');
                $table->string('ruangan');
                $table->enum('status', ['dijadwalkan', 'selesai', 'dibatalkan'])->default('dijadwalkan');
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidang');
    }
};
