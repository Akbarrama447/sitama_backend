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
        if (!Schema::hasTable('failed_jobs')) {
        // Create nilai_dosen_penguji table to store examiner grading data
        Schema::create('nilai_dosen_penguji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sidang_id')->constrained('sidang_tugas_akhir', 'id')->onDelete('cascade');
            $table->string('dosen_nip');
            $table->foreign('dosen_nip')->references('dosen_nip')->on('dosen')->onDelete('cascade');
            $table->decimal('nilai', 5, 2)->nullable(); // Overall nilai from examiner (0-100)
            $table->text('catatan')->nullable(); // Additional notes from examiner
            $table->timestamps();
            
            $table->unique(['sidang_id', 'dosen_nip']);
        });
    }
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_dosen_penguji');
    }
};