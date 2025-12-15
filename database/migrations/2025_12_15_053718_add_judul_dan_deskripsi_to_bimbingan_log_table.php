<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bimbingan_log', function (Blueprint $table) {
            $table->string('judul')->after('bimbingan_id');
            $table->text('deskripsi')->after('judul');
        });
    }

    public function down()
    {
        Schema::table('bimbingan_log', function (Blueprint $table) {
            $table->dropColumn(['judul', 'deskripsi']);
        });
    }
};
