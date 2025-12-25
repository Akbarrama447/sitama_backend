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
        if (!Schema::hasTable('unsur_nilai_dosen_pembimbing')) {
        Schema::create('unsur_nilai_dosen_pembimbing', function (Blueprint $table) {
            $table->id();
            
            // Kolom Foreign Key
            $table->string('dosen_nip')->index(); 
            $table->foreignId('sidang_id')->constrained('sidang_tugas_akhir')->onDelete('cascade');
            
            // Kolom Penilaian
            $table->integer('unsur_id')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();
            $table->integer('kerajinan_nilai')->nullable();
            $table->integer('keteguhan_nilai')->nullable();
            $table->integer('kemajuan_nilai')->nullable();
            $table->integer('total_nilai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Relasi ke tabel Dosen
            $table->foreign('dosen_nip')
                  ->references('dosen_nip')
                  ->on('dosen')
                  ->onDelete('cascade');

            // Agar tidak ada nilai ganda untuk unsur yang sama
            $table->unique(['sidang_id', 'dosen_nip', 'unsur_id'], 'pembimbing_unsur_unique');
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
        Schema::dropIfExists('unsur_nilai_dosen_pembimbing');
    }
}; // Tanda }; ini HANYA BOLEH ADA SATU di paling bawah file