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
        Schema::create('tugas_akhir', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 500);
            $table->text('deskripsi')->nullable();
            $table->string('status', 50);
            $table->string('tahun_akademik', 9);
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
