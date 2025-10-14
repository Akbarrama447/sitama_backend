<?php 

// app/Models/Jurusan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    
    // Satu Jurusan memiliki banyak Prodi
    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'jurusan_id');
    }
}