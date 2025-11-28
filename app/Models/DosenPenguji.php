<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class DosenPenguji extends Model
{
    use HasFactory;

    protected $table = 'dosen_penguji';

    // Dynamically set fillable based on available columns
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (Schema::hasTable('dosen_penguji')) {
            $this->fillable = Schema::getColumnListing('dosen_penguji');
        } else {
            // Default fillable if table doesn't exist
            $this->fillable = ['sidang_id', 'dosen_nip', 'peran'];
        }
    }

    public function sidang()
    {
        return $this->belongsTo(SidangTugasAkhir::class, 'sidang_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'dosen_nip');
    }
}