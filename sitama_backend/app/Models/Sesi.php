<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory;

    protected $table = 'sesi';
    protected $guarded = ['id'];


    public function jadwalSidangs()
    {
        return $this->hasMany(JadwalSidang::class, 'sesi_id');
    }
}