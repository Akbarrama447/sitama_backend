<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan'; // Sesuai nama tabelmu
    use HasFactory;
    public function jurusan()
{
    // Satu Prodi punya satu induk Jurusan
    return $this->belongsTo(Jurusan::class, 'jurusan_id');
}
}
