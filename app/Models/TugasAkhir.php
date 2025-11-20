<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    public function mahasiswa()
{
    // belongsTo artinya "Tugas Akhir ini MILIK Mahasiswa"
    // Parameter 2: nama kolom di tabel tugas_akhir (mahasiswa_nim)
    // Parameter 3: nama kolom di tabel mahasiswas (nim)
    return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nim', 'nim');
}


}
