<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSidang extends Model
{
    use HasFactory;

    protected $table = 'jadwal_sidang';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id')->withDefault([
            'nama_sesi' => 'Sesi ?',
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
        ]);
    }
}