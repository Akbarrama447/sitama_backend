<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class TugasAkhir extends Model
{
    use HasFactory;
    protected $table = 'tugas_akhir';

    // Dynamically set fillable based on available columns
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (Schema::hasTable('tugas_akhir')) {
            $this->fillable = Schema::getColumnListing('tugas_akhir');
        }
    }

    public function mahasiswa()
    {
        // belongsTo artinya "Tugas Akhir ini MILIK Mahasiswa"
        // Parameter 2: nama kolom di tabel tugas_akhir (mahasiswa_nim)
        // Parameter 3: nama kolom di tabel mahasiswas (nim)
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nim', 'nim');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'tugas_akhir_id');
    }

    public function bimbinganLogs()
    {
        return $this->hasManyThrough(BimbinganLog::class, Bimbingan::class, 'tugas_akhir_id', 'bimbingan_id');
    }

    public function sidang()
    {
        return $this->hasOne(SidangTugasAkhir::class, 'tugas_akhir_id');
    }

    public function dosenPembimbing1()
    {
        if (Schema::hasColumn('tugas_akhir', 'pembimbing_1_nip')) {
            return $this->belongsTo(Dosen::class, 'pembimbing_1_nip', 'dosen_nip');
        } else {
            // If column doesn't exist, use the bimbingan table approach
            return $this->belongsToMany(Dosen::class, 'bimbingan', 'tugas_akhir_id', 'dosen_nip')
                        ->where('urutan', 1);
        }
    }

    public function dosenPembimbing2()
    {
        if (Schema::hasColumn('tugas_akhir', 'pembimbing_2_nip')) {
            return $this->belongsTo(Dosen::class, 'pembimbing_2_nip', 'dosen_nip');
        } else {
            // If column doesn't exist, use the bimbingan table approach
            return $this->belongsToMany(Dosen::class, 'bimbingan', 'tugas_akhir_id', 'dosen_nip')
                        ->where('urutan', 2);
        }
    }
}
