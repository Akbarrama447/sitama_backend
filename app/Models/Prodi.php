<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    } 
}
