<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnsurPenilaianPenguji extends Model
{
    use HasFactory;
    protected $table = 'unsur_nilai_penguji';
    protected $fillable = ['kriteria', 'bobot'];

    public $timestamps = false;
}