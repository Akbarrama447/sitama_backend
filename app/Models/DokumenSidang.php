<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSidang extends Model
{
    use HasFactory;

    protected $table = 'dokumen_sidang';
    protected $primaryKey = 'dokumen_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false; // karena struktur dari PM tidak ada timestamps

    protected $fillable = [
        'dokumen_syarat',
        'dokumen_file',
        'verified',
        'keterangan',
        'tipe_dokumen'
    ];

    protected $casts = [
        'verified' => 'boolean',
    ];
}