<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_unsur_nilai_table.php

        public function up(): void
        {
            Schema::create('unsur_nilai', function (Blueprint $table) {
                $table->id();
                $table->string('nama_unsur');
                $table->enum('tipe', ['pembimbing', 'penguji']); // Rubrik bisa beda untuk pembimbing & penguji
                $table->unsignedTinyInteger('bobot')->nullable(); // Bobot nilai dalam persen
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unsur_nilai');
    }
};
