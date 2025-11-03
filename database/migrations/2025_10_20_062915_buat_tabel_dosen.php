<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');

            // PASTIKAN BARIS INI ADA
            $table->foreignId('prodi_id')->constrained('prodi');

            $table->string('dosen_nama');
            $table->string('dosen_nip')->unique(); // Sesuai kesepakatan terakhir kita
            $table->timestamps();
        });
    }

    // ...
};