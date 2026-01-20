<?php

namespace App\Models\ModelApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelApi\DokumenSidang;

class SyaratSidang extends Model
{
    use HasFactory;

    protected $table = 'syarat_sidang';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false; // karena struktur dari PM tidak ada timestamps

    protected $fillable = [
        'tugas_akhir_id',
        'dokumen_id',
        'mhs_nim',
        'dokumen_file_original',
        'dokumen_file',
        'verified',
        'tanggal_upload'
    ];

    protected $casts = [
        'verified' => 'integer',
        'tanggal_upload' => 'datetime',
    ];

    // Relasi
    public function dokumen()
    {
        return $this->belongsTo(DokumenSidang::class, 'dokumen_id', 'dokumen_id');
    }
}