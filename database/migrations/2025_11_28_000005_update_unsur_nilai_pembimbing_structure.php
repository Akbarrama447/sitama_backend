<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to update unsur_nilai_pembimbing table structure to match the correct database structure
     */
    public function up()
    {
        // Update table structure only if it exists
        if (Schema::hasTable('unsur_nilai_pembimbing')) {
            Schema::table('unsur_nilai_pembimbing', function (Blueprint $table) {
                // Drop old columns if they exist
                if (Schema::hasColumn('unsur_nilai_pembimbing', 'kerajinan_nilai')) {
                    $table->dropColumn('kerajinan_nilai');
                }
                if (Schema::hasColumn('unsur_nilai_pembimbing', 'keteguhan_nilai')) {
                    $table->dropColumn('keteguhan_nilai');
                }
                if (Schema::hasColumn('unsur_nilai_pembimbing', 'kemajuan_nilai')) {
                    $table->dropColumn('kemajuan_nilai');
                }
                if (Schema::hasColumn('unsur_nilai_pembimbing', 'total_nilai')) {
                    $table->dropColumn('total_nilai');
                }

                // Add correct columns if they don't exist
                if (!Schema::hasColumn('unsur_nilai_pembimbing', 'nilai_kedisiplinan')) {
                    $table->integer('nilai_kedisiplinan')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_pembimbing', 'nilai_kreativitas')) {
                    $table->integer('nilai_kreativitas')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_pembimbing', 'nilai_penguasaan_materi')) {
                    $table->integer('nilai_penguasaan_materi')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_pembimbing', 'nilai_kelengkapan')) {
                    $table->integer('nilai_kelengkapan')->nullable();
                }
                
                // Keep catatan column if exists, add if doesn't exist
                if (!Schema::hasColumn('unsur_nilai_pembimbing', 'catatan')) {
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
        if (Schema::hasTable('unsur_nilai_pembimbing')) {
            Schema::table('unsur_nilai_pembimbing', function (Blueprint $table) {
                // Drop the correct columns
                if (Schema::hasColumn('unsur_nilai_pembimbing', 'nilai_kedisiplinan')) {
                    $table->dropColumn('nilai_kedisiplinan');
                }
                if (Schema::hasColumn('unsur_nilai_pembimbing', 'nilai_kreativitas')) {
                    $table->dropColumn('nilai_kreativitas');
                }
                if (Schema::hasColumn('unsur_nilai_pembimbing', 'nilai_penguasaan_materi')) {
                    $table->dropColumn('nilai_penguasaan_materi');
                }
                if (Schema::hasColumn('unsur_nilai_pembimbing', 'nilai_kelengkapan')) {
                    $table->dropColumn('nilai_kelengkapan');
                }
                
                // Add back old columns if needed
                if (!Schema::hasColumn('unsur_nilai_pembimbing', 'kerajinan_nilai')) {
                    $table->integer('kerajinan_nilai')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_pembimbing', 'keteguhan_nilai')) {
                    $table->integer('keteguhan_nilai')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_pembimbing', 'kemajuan_nilai')) {
                    $table->integer('kemajuan_nilai')->nullable();
                }
                if (!Schema::hasColumn('unsur_nilai_pembimbing', 'total_nilai')) {
                    $table->integer('total_nilai')->nullable();
                }
            });
        }
    }
};