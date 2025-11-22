<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogBimbingan extends Model
{
    // Nama tabel di database lo 'bimbingan_log', bukan plural default laravel
    protected $table = 'bimbingan_log';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'bimbingan_id',
        'judul',
        'deskripsi',
        'tanggal',
        'file_path',
        'status'
    ];

    // Relasi ke tabel 'bimbingan'
    public function bimbingan(): BelongsTo
    {
        return $this->belongsTo(Bimbingan::class, 'bimbingan_id');
    }
}