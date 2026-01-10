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
        return $this->hasOne(TugasAkhir::class, 'mhs_nim', 'nim');
    }
}