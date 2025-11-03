<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TugasAkhir extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'tugas_akhir';

    //
    // --- INI SOLUSINYA ---
    //
    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'status',
        'tahun_akademik',
    ];
    // --- SELESAI ---
    //


    /**
     * Relasi ke Bimbingan (untuk ambil dosen pembimbing).
     */
    public function bimbingan(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'tugas_akhir_id', 'id');
    }

    /**
     * Relasi ke Mahasiswa (untuk ambil anggota kelompok).
     */
    public function mahasiswa(): BelongsToMany
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'tugas_akhir_anggota', // Nama tabel pivot
            'tugas_akhir_id',     // Foreign key di pivot untuk model ini
            'mhs_nim'             // Foreign key di pivot untuk model Mahasiswa
        );
    }
}

