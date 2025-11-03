<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SidangTugasAkhir extends Model
{
    protected $table = 'sidang_tugas_akhir';

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