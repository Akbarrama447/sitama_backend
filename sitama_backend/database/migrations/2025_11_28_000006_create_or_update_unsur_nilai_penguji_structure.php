<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to create unsur_nilai_penguji table structure based on typical examiner evaluation criteria
     */
    public function up()
    {
        // Create unsur_nilai_penguji table if it doesn't exist
        if (!Schema::hasTable('unsur_nilai_penguji')) {
            Schema::create('unsur_nilai_penguji', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sidang_id')->constrained('sidang_tugas_akhir', 'id')->onDelete('cascade');
                $table->string('dosen_nip');
                $table->foreign('dosen_nip')->references('dosen_nip')->on('dosen')->onDelete('cascade');
                $table->integer('unsur_id')->nullable(); // ID for the specific aspect being graded
                $table->decimal('nilai', 5, 2)->nullable(); // Overall nilai (0-100)
                $table->integer('nilai_sistematika')->nullable(); // Sistematika penulisan (0-100)
                $table->integer('nilai_metodologi')->nullable(); // Metodologi (0-100)
                $table->integer('nilai_pemahaman_materi')->nullable(); // Pemahaman materi (0-100)
                $table->integer('nilai_presentasi')->nullable(); // Presentasi (0-100)
                $table->integer('nilai_kelengkapan')->nullable(); // Kelengkapan (0-100)
                $table->text('catatan')->nullable(); // Additional notes
                $table->timestamps();

                $table->unique(['sidang_id', 'dosen_nip', 'unsur_id']);
            });
        } elseif (Schema::hasTable('unsur_nilai_penguji')) {
            // If table exists, update it to match the correct structure
            Schema::table('unsur_nilai_penguji', function (Blueprint $table) {
                // Add any missing columns based on the defined structure
                if (!Schema::hasColumn('unsur_nilai_penguji', 'nilai_sistematika')) {
                    $table->integer('nilai_sistematika')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_penguji', 'nilai_metodologi')) {
                    $table->integer('nilai_metodologi')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_penguji', 'nilai_pemahaman_materi')) {
                    $table->integer('nilai_pemahaman_materi')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_penguji', 'nilai_presentasi')) {
                    $table->integer('nilai_presentasi')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_penguji', 'nilai_kelengkapan')) {
                    $table->integer('nilai_kelengkapan')->nullable();
                }
                
                // Add the foreign key constraint if it doesn't exist
                if (!Schema::hasColumn('unsur_nilai_penguji', 'unsur_id')) {
                    $table->integer('unsur_id')->nullable();
                }
                
                if (!Schema::hasColumn('unsur_nilai_penguji', 'nilai')) {
                    $table->decimal('nilai', 5, 2)->nullable();
                }
                
                if (!Schema::hasColumn('unsur_nilai_penguji', 'catatan')) {
                    $table->text('catatan')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('unsur_nilai_penguji');
    }
};