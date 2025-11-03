<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $table = 'bimbingan';

    public function dosen()
    {
     return $this->belongsTo(Dosen::class, 'dosen_nip');
    }
}

