<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_penguji_table.php

        public function up(): void
        {
            Schema::create('penguji', function (Blueprint $table) {
                $table->foreignId('sidang_id')->constrained('sidang')->onDelete('cascade');
                $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
                $table->enum('peran', ['ketua_penguji', 'penguji_1', 'penguji_2']);
                
                // Primary key gabungan
                $table->primary(['sidang_id', 'dosen_id']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penguji');
    }
};
