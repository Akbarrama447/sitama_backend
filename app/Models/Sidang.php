<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidang extends Model
{
    use HasFactory;

    protected $table = 'sidang_tugas_akhir'; // karena nama tabelnya ini
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'tugas_akhir_id',
        'jadwal_sidang_id',
        'status',
    ];
}