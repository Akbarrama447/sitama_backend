<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisiTugasAkhir extends Model
{
    use HasFactory;

    protected $table = 'revisi_tugas_akhir';

    protected $fillable = [
        'mhs_nim',
        'tugas_akhir_id',
        'dosen_nip',
        'catatan_revisi',
        'status_revisi',
        'file_revisi',
    ];

    protected $casts = [
        'status_revisi' => 'integer',
    ];

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class, 'tugas_akhir_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'dosen_nip');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mhs_nim', 'mhs_nim');
    }
}