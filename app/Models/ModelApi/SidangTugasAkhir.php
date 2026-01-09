<?php

namespace App\Models\ModelApi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ModelApi\TugasAkhir;
use App\Models\ModelApi\JadwalSidang;
use App\Models\ModelApi\DosenPenguji;
use App\Models\ModelApi\Mahasiswa;

class SidangTugasAkhir extends Model
{
    protected $table = 'sidang_tugas_akhir';

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'tugas_akhir_id',
        'mhs_nim',
        'jadwal_sidang_id',
        'sekretaris_nip',
        'status',
        'nilai_akhir',
    ];

    // Relasi ke TugasAkhir
    public function tugasAkhir(): BelongsTo
    {
        return $this->belongsTo(TugasAkhir::class, 'tugas_akhir_id');
    }

    // Relasi ke Mahasiswa (yang mendaftar sidang)
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mhs_nim', 'mhs_nim');
    }

    // Relasi ke JadwalSidang
    public function jadwalSidang(): BelongsTo
    {
        return $this->belongsTo(JadwalSidang::class, 'jadwal_sidang_id');
    }

    // Relasi ke DosenPenguji
    public function penguji(): HasMany
    {
        return $this->hasMany(DosenPenguji::class, 'sidang_id');
    }
}