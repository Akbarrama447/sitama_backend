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
        'mhs_nim',
        'tanggal',
        'catatan',
        'status', // 0 = Menunggu verifikasi, 1 = Disetujui (misalnya)
        'file_path',
        'judul',
        'deskripsi',
    ];

    // Relasi ke tabel 'bimbingan'
    public function bimbingan(): BelongsTo
    {
        return $this->belongsTo(Bimbingan::class, 'bimbingan_id');
    }

    // Relasi ke tabel 'mahasiswa'
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mhs_nim', 'mhs_nim');
    }
}