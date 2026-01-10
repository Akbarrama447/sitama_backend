<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to update dosen relationships structure for proper separation
     */
    public function up(): void
    {
        // Ensure the bimbingan table has all required columns (as added in previous migration)
        if (!Schema::hasColumn('bimbingan', 'urutan')) {
            Schema::table('bimbingan', function (Blueprint $table) {
                $table->integer('urutan')->nullable()->after('dosen_nip');
            });
        }

        // Optionally, if you want to eventually phase out the old columns in tugas_akhir table:
        // Add any additional constraints or validations needed for the new structure
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally revert changes related to new structure
        // Note: Be careful with down operations that might result in data loss
    }
};