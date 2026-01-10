<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiDosenPembimbing extends Model
{
    use HasFactory;
    protected $table = 'nilai_dosen_pembimbing';
    protected $fillable = ['sidang_id', 'dosen_nip', 'unsur_id', 'nilai'];

    public function unsur()
    {
        return $this->belongsTo(UnsurPenilaianPembimbing::class, 'unsur_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'dosen_nip');
    }
}