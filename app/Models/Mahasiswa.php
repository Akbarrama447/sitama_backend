<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    

    public function Mahasiswa() {
        return $this->belongsTo(User::class);
    }

}
