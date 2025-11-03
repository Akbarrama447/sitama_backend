<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalSidang extends Model
{
    protected $table = 'jadwal_sidang';

    // Relasi ke tabel Sesi (untuk dapat JAM)
    public function sesi(): BelongsTo
    {
        return $this->belongsTo(Sesi::class, 'sesi_id');
    }

    // Relasi ke tabel Ruangan (untuk dapat TEMPAT)
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    // Relasi ke SidangTugasAkhir (Satu jadwal bisa dipakai banyak sidang)
    public function sidangTugasAkhir(): HasMany
    {
        return $this->hasMany(SidangTugasAkhir::class, 'jadwal_sidang_id');
    }
}