<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_tugas_akhir_table.php

public function up(): void
{
    Schema::create('tugas_akhir', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->text('abstrak')->nullable();
        $table->enum('status', [
            'pengajuan', 
            'bimbingan', 
            'siap_sidang', 
            'selesai', 
            'ditolak'
        ])->default('pengajuan');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_akhir');
    }
};
