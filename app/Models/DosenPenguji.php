<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DosenPenguji extends Model
{
    protected $table = 'dosen_penguji';

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'dosen_nip');
    }
}