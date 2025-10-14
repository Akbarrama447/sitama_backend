<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_pembimbing_table.php

        public function up(): void
        {
            Schema::create('pembimbing', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tugas_akhir_id')->constrained('tugas_akhir')->onDelete('cascade');
                $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
                $table->enum('peran', ['pembimbing_1', 'pembimbing_2']);
                $table->enum('status', ['diajukan', 'diterima', 'ditolak'])->default('diajukan');
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbing');
    }
};
