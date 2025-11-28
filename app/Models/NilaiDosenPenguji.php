<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class NilaiDosenPenguji extends Model
{
    use HasFactory;

    // Dynamically set table name based on which table exists
    protected $table;

    // Dynamically set fillable based on available columns
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Check which table exists and set the table name accordingly
        if (Schema::hasTable('unsur_nilai_penguji')) {
            $this->table = 'unsur_nilai_penguji';
        } else {
            $this->table = 'unsur_nilai_dosen_penguji'; // fallback name in case different
        }

        if (Schema::hasTable($this->table)) {
            $this->fillable = Schema::getColumnListing($this->table);
        } else {
            // Default fillable if table doesn't exist
            $this->fillable = [
                'sidang_id',
                'dosen_nip',
                'unsur_id',
                'nilai',
                'nilai_sistematika',
                'nilai_metodologi',
                'nilai_pemahaman_materi',
                'nilai_presentasi',
                'nilai_kelengkapan',
                'catatan'
            ];
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