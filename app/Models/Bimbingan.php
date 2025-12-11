<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bimbingan extends Model
{
    use HasFactory;

    // Tentukan nama tabelnya
    protected $table = 'bimbingan';

    /**
     * Definisikan relasi ke model Dosen.
     * Satu data bimbingan 'dimiliki oleh' satu Dosen.
     */
    public function dosen(): BelongsTo
    {
        // Relasi via 'dosen_nip' di tabel 'bimbingan'
        // ke 'dosen_nip' di tabel 'dosen'
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'dosen_nip');
    }

    /**
     * Definisikan relasi ke model TugasAkhir.
     * Satu data bimbingan 'dimiliki oleh' satu Tugas Akhir.
     */
    public function tugasAkhir(): BelongsTo
    {
        // Relasi via 'tugas_akhir_id' di tabel 'bimbingan'
        // ke 'id' di tabel 'tugas_akhir'
        return $this->belongsTo(TugasAkhir::class, 'tugas_akhir_id', 'id');
    }
}
