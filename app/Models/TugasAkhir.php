<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    protected $table = 'tugas_akhir';
    protected $guarded = ['id'];

    public function mahasiswa()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'tugas_akhir_anggota',
            'tugas_akhir_id',
            'mhs_nim',
            'id',
            'mhs_nim'
        );
    }

    public function getMahasiswaAttribute()
    {
        if ($this->relationLoaded('mahasiswa')) {
            return $this->getRelation('mahasiswa')->first();
        }
        return $this->mahasiswa()->first();
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'tugas_akhir_id');
    }

    public function sidang()
    {
        return $this->hasOne(SidangTugasAkhir::class, 'tugas_akhir_id');
    }
}