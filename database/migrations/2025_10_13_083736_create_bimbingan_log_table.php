<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_bimbingan_log_table.php

public function up(): void
{
    Schema::create('bimbingan_log', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pembimbing_id')->constrained('pembimbing')->onDelete('cascade');
        $table->text('catatan_dosen')->nullable();
        $table->string('file_mahasiswa')->nullable(); // Path ke file yang diupload mahasiswa
        $table->string('file_dosen')->nullable(); // Path ke file revisi dari dosen
        
        // Kolom ini berfungsi sebagai "centang" atau ACC dari dosen
        $table->boolean('status_acc')->default(false); 
        
        $table->timestamps(); // Untuk mencatat tanggal bimbingan
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingan_log');
    }
};
