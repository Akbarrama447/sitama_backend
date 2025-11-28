<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create unsur_nilai_dosen_pembimbing table to store pembimbing grading data
        Schema::create('unsur_nilai_dosen_pembimbing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sidang_id')->constrained('sidang_tugas_akhir', 'id')->onDelete('cascade');
            $table->string('dosen_nip');
            $table->foreign('dosen_nip')->references('dosen_nip')->on('dosen')->onDelete('cascade');
            $table->integer('unsur_id')->nullable(); // ID for the specific aspect being graded
            $table->decimal('nilai', 5, 2)->nullable(); // Overall nilai (0-100)
            $table->integer('kerajinan_nilai')->nullable(); // Kerajinan nilai (0-100)
            $table->integer('keteguhan_nilai')->nullable(); // Keteguhan nilai (0-100)
            $table->integer('kemajuan_nilai')->nullable(); // Kemajuan nilai (0-100)
            $table->integer('total_nilai')->nullable(); // Total nilai (0-100)
            $table->text('catatan')->nullable(); // Additional notes
            $table->timestamps();
            
            $table->unique(['sidang_id', 'dosen_nip', 'unsur_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unsur_nilai_dosen_pembimbing');
    }
};