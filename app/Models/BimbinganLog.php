<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganLog extends Model
{
    use HasFactory;

    // Kasih tau Laravel nama tabel aslinya (karena ada underscore)
    protected $table = 'bimbingan_log'; // Atau 'bimbingan_log' (sesuaikan nama tabel di database kamu persis!)
    protected $guarded = [];

    public function bimbingan()
    {
        return $this->belongsTo(Bimbingan::class, 'bimbingan_id');
    }

    public function scopeOrderByTanggalDesc($query)
    {
        return $query->orderBy('tanggal', 'desc');
    }
}
