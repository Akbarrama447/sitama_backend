<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';

    public function tugasAkhir()
    {
        // hasOne artinya "Mahasiswa ini PUNYA SATU Tugas Akhir"
        return $this->hasOne(TugasAkhir::class, 'mahasiswa_nim', 'nim');
}
}