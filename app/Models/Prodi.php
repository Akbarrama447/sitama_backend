<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import untuk relasi
use Illuminate\Database\Eloquent\Relations\HasMany;   // Import untuk relasi

class Prodi extends Model
{
    use HasFactory;

    // --- 1. KONFIGURASI TABEL (WAJIB KARENA KUSTOM) ---

    /**
     * Memberitahu Laravel nama tabel yang benar.
     * (Karena kita pakai 'prodi', bukan 'prodis')
     */
    protected $table = 'prodi';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'jurusan_id',
        'nama_prodi',
    ];


    // --- 2. RELASI ELOQUENT ---

    /**
     * Mendefinisikan relasi bahwa Prodi ini DIMILIKI OLEH satu Jurusan.
     * Relasi: one-to-many (inverse)
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Mendefinisikan relasi bahwa satu Prodi MEMILIKI BANYAK Mahasiswa.
     * Relasi: one-to-many
     */
    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'prodi_id');
    }

    /**
     * Mendefinisikan relasi bahwa satu Prodi MEMILIKI BANYAK Dosen.
     * Relasi: one-to-many
     */
    public function dosens(): HasMany
    {
        return $this->hasMany(Dosen::class, 'prodi_id');
    }
}

