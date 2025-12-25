<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('permissions', function (Blueprint $table) {
        // 1. Kita bikin kolom menu_id, boleh kosong (nullable)
        // ditaruh setelah kolom 'id' biar rapi
        $table->unsignedBigInteger('menu_id')->nullable()->after('id');

        // 2. (Opsional tapi Recommended) Sambungin foreign key biar aman
        // Kalau menu dihapus, permission nggak error (atau ikut kehapus terserah logicmu)
        // Asumsi nama tabel menumu adalah 'menus'
        $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade'); 
    });
}

public function down()
{
    Schema::table('permissions', function (Blueprint $table) {
        // Hapus foreign key dulu baru kolomnya (biar ga error pas rollback)
        $table->dropForeign(['menu_id']);
        $table->dropColumn('menu_id');
    });
}
};
