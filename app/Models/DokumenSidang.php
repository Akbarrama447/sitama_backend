<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenSidang extends Model
{
    use HasFactory;

    // Tentukan nama tabelnya
    protected $table = 'dokumen_sidang';

    // Kolom yang boleh diisi
    protected $fillable = [
        'syarat_sidang_id',
        'nama_dokumen',
        'path_dokumen',
        'tipe_dokumen',
    ];

    /**
     * Relasi ke SyaratSidang
     */
    public function syaratSidang(): BelongsTo
    {
        // Primary key di tabel syarat_sidang adalah 'syarat_sidang_id'
        return $this->belongsTo(\App\Models\SyaratSidang::class, 'syarat_sidang_id', 'syarat_sidang_id');
    }
}