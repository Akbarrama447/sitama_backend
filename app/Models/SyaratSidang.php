<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SyaratSidang extends Model
{
    use HasFactory;

    // Tentukan nama tabelnya
    protected $table = 'syarat_sidang';

    // Kolom yang boleh diisi
    protected $fillable = [
        'tugas_akhir_id',
        'nama_syarat',
        'file_path',
        'status',
    ];

    /**
     * Relasi ke TugasAkhir
     */
    public function tugasAkhir(): BelongsTo
    {
        return $this->belongsTo(TugasAkhir::class, 'tugas_akhir_id', 'id');
    }
}
