<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::table('bimbingan_log', function (Blueprint $table) {
            if (!Schema::hasColumn('bimbingan_log', 'judul')) {
                $table->string('judul')->after('bimbingan_id');
            }

            if (!Schema::hasColumn('bimbingan_log', 'deskripsi')) {
                $table->text('deskripsi')->after('judul');
            }

            if (Schema::hasColumn('bimbingan_log', 'catatan')) {
                $table->dropColumn('catatan'); // sudah diganti deskripsi
            }
        });
    }

    public function down()
    {
        Schema::table('bimbingan_log', function (Blueprint $table) {
            if (!Schema::hasColumn('bimbingan_log', 'catatan')) {
                $table->text('catatan');
            }
            $table->dropColumn(['judul', 'deskripsi']);
        });
    }
};