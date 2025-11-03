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
}
