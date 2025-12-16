<?php

namespace App\Models\ModelApi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ModelApi\TugasAkhir;
use App\Models\ModelApi\JadwalSidang;
use App\Models\ModelApi\DosenPenguji;

class SidangTugasAkhir extends Model
{
    protected $table = 'sidang_tugas_akhir';

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'tugas_akhir_id',
        'jadwal_sidang_id',
        'status',
    ];

    // Relasi ke TugasAkhir (untuk dapat JUDUL, DESKRIPSI)
    public function tugasAkhir(): BelongsTo
    {
        return $this->belongsTo(TugasAkhir::class, 'tugas_akhir_id');
    }

    // Relasi ke JadwalSidang (untuk dapat TANGGAL)
    public function jadwalSidang(): BelongsTo
    {
        return $this->belongsTo(JadwalSidang::class, 'jadwal_sidang_id');
    }

    // Relasi ke DosenPenguji (untuk dapat list PENGUJI)
    public function penguji(): HasMany
    {
        // 'sidang_id' adalah foreign key di tabel 'dosen_penguji'
        return $this->hasMany(DosenPenguji::class, 'sidang_id');
    }
}