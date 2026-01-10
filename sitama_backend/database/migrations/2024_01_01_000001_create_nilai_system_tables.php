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
        // Create nilai_dosen_penguji table if it doesn't exist
        if (!Schema::hasTable('nilai_dosen_penguji')) {
            Schema::create('nilai_dosen_penguji', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sidang_id')->constrained('sidang_tugas_akhir', 'id')->onDelete('cascade');
                $table->string('dosen_nip');
                $table->foreign('dosen_nip')->references('dosen_nip')->on('dosen')->onDelete('cascade');
                $table->decimal('nilai', 5, 2)->nullable(); // Overall nilai (0-100)
                $table->text('catatan')->nullable();
                $table->timestamps();
                
                $table->unique(['sidang_id', 'dosen_nip']);
            });
        }
        
        // Ensure unsur_nilai_dosen_pembimbing table has necessary columns
        if (Schema::hasTable('unsur_nilai_dosen_pembimbing')) {
            Schema::table('unsur_nilai_dosen_pembimbing', function (Blueprint $table) {
                if (!Schema::hasColumn('unsur_nilai_dosen_pembimbing', 'kerajinan_nilai')) {
                    $table->integer('kerajinan_nilai')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_dosen_pembimbing', 'keteguhan_nilai')) {
                    $table->integer('keteguhan_nilai')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_dosen_pembimbing', 'kemajuan_nilai')) {
                    $table->integer('kemajuan_nilai')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_dosen_pembimbing', 'total_nilai')) {
                    $table->integer('total_nilai')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_dosen_pembimbing', 'catatan')) {
                    $table->text('catatan')->nullable();
                }
            });
        }
        
        // Ensure sidang_tugas_akhir table has necessary columns
        if (Schema::hasTable('sidang_tugas_akhir')) {
            Schema::table('sidang_tugas_akhir', function (Blueprint $table) {
                if (!Schema::hasColumn('sidang_tugas_akhir', 'penguji_3_nip')) {
                    $table->string('penguji_3_nip')->nullable();
                }
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