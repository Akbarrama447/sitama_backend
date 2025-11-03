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
        Schema::create('prodi_dosen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id')->constrained('prodi');
            $table->string('dosen_nip');
            $table->foreign('dosen_nip')->references('dosen_nip')->on('dosen');
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
