<?php

namespace App\Models\ModelApi;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    // protected $table = 'ruangan';
    // (Tidak perlu, karena 'Ruangan' -> 'ruangans'.
    // Wait, tabelnya `ruangan`. Ya, perlu.)
    protected $table = 'ruangan';
}