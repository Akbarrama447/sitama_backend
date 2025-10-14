    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_master_syarat_table.php

        public function up(): void
        {
            Schema::create('master_syarat', function (Blueprint $table) {
                $table->id();
                $table->foreignId('prodi_id')->constrained('prodi')->onDelete('cascade');
                $table->string('nama_syarat');
                $table->enum('tipe_bukti', ['upload_file', 'checklist_manual'])->default('upload_file');
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_syarat');
    }
};
