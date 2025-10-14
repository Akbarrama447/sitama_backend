<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_usulan_jadwal_sidang_table.php

        public function up(): void
        {
            Schema::create('usulan_jadwal_sidang', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tugas_akhir_id')->constrained('tugas_akhir')->onDelete('cascade');
                $table->date('tanggal_usulan');
                $table->time('waktu_usulan');
                $table->enum('status', ['diajukan', 'disetujui', 'ditolak'])->default('diajukan');
                $table->text('catatan_admin')->nullable();
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulan_jadwal_sidang');
    }
};
