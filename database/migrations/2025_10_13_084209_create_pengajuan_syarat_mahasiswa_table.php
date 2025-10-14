<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_pengajuan_syarat_mahasiswa_table.php

        public function up(): void
        {
            Schema::create('pengajuan_syarat_mahasiswa', function (Blueprint $table) {
                $table->id();
                $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
                $table->foreignId('master_syarat_id')->constrained('master_syarat')->onDelete('cascade');
                $table->string('file_path')->nullable(); // Diisi jika tipe_bukti 'upload_file'
                $table->enum('status', ['belum_diajukan', 'diajukan', 'valid', 'tidak_valid'])->default('belum_diajukan');
                
                // ID admin/user yang melakukan verifikasi
                $table->foreignId('verified_by_user_id')->nullable()->constrained('users')->onDelete('set null'); 
                
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_syarat_mahasiswa');
    }
};
