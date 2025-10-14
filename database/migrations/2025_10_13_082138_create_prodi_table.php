<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 // database/migrations/xxxx_xx_xx_xxxxxx_create_prodi_table.php

public function up(): void
{
    Schema::create('prodi', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel jurusan
        $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
        $table->string('nama_prodi');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
