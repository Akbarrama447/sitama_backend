<?php

namespace App\Models\ModelApi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileDokumenSidang extends Model
{
    protected $table = 'file_dokumen_sidang';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'syarat_sidang_id',
        'nama_file',
        'path_file',
        'tipe_file',
        'ukuran_file',
    ];

    protected $casts = [
        'ukuran_file' => 'integer',
    ];

    /**
     * Relasi ke model SyaratSidang
     */
    public function syaratSidang(): BelongsTo
    {
        return $this->belongsTo(SyaratSidang::class, 'syarat_sidang_id', 'id');
    }
}