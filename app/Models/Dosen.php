<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    /**
     * Memberitahu Laravel nama tabel yang benar.
     */
    protected $table = 'dosen';

    /**
     * Mendefinisikan relasi bahwa data Dosen ini dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mendefinisikan relasi bahwa satu Dosen dimiliki oleh satu Prodi.
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
}
