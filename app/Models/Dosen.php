<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'dosen_nip';
    public $incrementing = false;
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'dosen_nip', 'dosen_nip');
    }

    public function penguji()
    {
        return $this->hasMany(DosenPenguji::class, 'dosen_nip', 'dosen_nip');
    }
}

