<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sidang extends Model
{
    protected $table = 'sidang_tugas_akhir';
    protected $guarded = [];

    // Relasi ke Tugas Akhir
    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class, 'tugas_akhir_id');
    }
}