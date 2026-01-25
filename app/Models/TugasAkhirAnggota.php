<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasAkhirAnggota extends Model
{
    protected $table = 'tugas_akhir_anggota';

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'mhs_nim','mhs_nim');
    }

    public function tugasAkhir(){
        return $this->belongsTo(TugasAkhir::class, 'tugasAkhir_id');
    }
}
