<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_dosen_prodi_table.php

        public function up(): void
        {
            Schema::create('dosen_prodi', function (Blueprint $table) {
                $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
                $table->foreignId('prodi_id')->constrained('prodi')->onDelete('cascade');
                
                // Menetapkan composite primary key untuk mencegah duplikasi data
                $table->primary(['dosen_id', 'prodi_id']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_prodi');
    }
};
