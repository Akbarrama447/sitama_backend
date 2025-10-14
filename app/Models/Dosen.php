<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    public function Dosen() {
        return $this->belongsTo(User::class);
    }
}
