<?php

namespace App\Models\ModelApi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ModelApi\Mahasiswa;

class TugasAkhirAnggota extends Model
{
    protected $table = 'tugas_akhir_anggota';

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mhs_nim', 'mhs_nim');
    }
}