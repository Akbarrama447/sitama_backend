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
        Schema::create('bimbingan_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bimbingan_id')->constrained('bimbingan')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('catatan');
            $table->boolean('status')->default(false); // Revisi dari is_approved
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
