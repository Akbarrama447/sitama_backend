<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('configs')) {
        Schema::create('configs', function (Blueprint $table) {
        $table->id();
        $table->string('setting_key')->unique(); // Contoh: 'min_bimbingan'
        $table->string('setting_label');         // Contoh: 'Minimal Bimbingan'
        $table->enum('setting_type', ['binary', 'value', 'ref']); 
        $table->string('setting_value');         // Simpan angka '8' di sini
        $table->boolean('is_visible')->default(true);
        $table->timestamps();
        });
    }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
