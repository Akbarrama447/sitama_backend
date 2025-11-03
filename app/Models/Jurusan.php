<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import untuk relasi

class Jurusan extends Model
{
    use HasFactory;

    // --- 1. KONFIGURASI TABEL (WAJIB) ---
    /**
     * Memberitahu Laravel nama tabel yang benar.
     * (Karena kita pakai 'jurusan', bukan 'jurusans')
     */
    protected $table = 'jurusan';

    /**
     * Kolom yang boleh diisi.
     */
    protected $fillable = [
        'nama_jurusan',
    ];

    
    // --- 2. RELASI ELOQUENT ---

    /**
     * Mendefinisikan relasi bahwa satu Jurusan MEMILIKI BANYAK Prodi.
     * Relasi: one-to-many
     */
    public function prodis(): HasMany
    {
        // Kita tidak perlu 'use App\Models\Prodi' di sini
        // karena model Prodi ada di namespace yang sama.
        return $this->hasMany(Prodi::class, 'jurusan_id');
    }
}
