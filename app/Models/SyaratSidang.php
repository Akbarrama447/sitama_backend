<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SyaratSidang extends Model
{
    use HasFactory;

    // Tentukan nama tabelnya
    protected $table = 'syarat_sidang';

    // Primary key yang benar sesuai dengan database
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi massal sesuai dengan struktur database sebenarnya
    protected $fillable = [
        'tugas_akhir_id',
        'nama_syarat',
        'status',
    ];

    // Kolom yang tidak boleh diisi massal (guarded)
    protected $guarded = ['id'];

    /**
     * Relasi ke TugasAkhir (menggunakan tugas_akhir_id)
     */
    public function tugasAkhir(): BelongsTo
    {
        return $this->belongsTo(TugasAkhir::class, 'tugas_akhir_id', 'id');
    }
}
