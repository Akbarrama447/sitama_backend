<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // <-- 1. PASTIKAN INI ADA
use App\Models\User;
use App\Models\Prodi;
use App\Models\TugasAkhir; // <-- 2. TAMBAHKAN INI JUGA

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'mhs_nim';
    public $incrementing = false;
    protected $keyType = 'int';

    // Kolom yang boleh diisi
    protected $fillable = [
        'mhs_nim',
        'user_id',
        'prodi_id',
        'mhs_nama',
        'tahun_masuk',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id');
    }

    /**
     * 3. INI FUNGSI YANG HILANG
     * Definisikan relasi ke TugasAkhir (many-to-many).
     * Satu mahasiswa bisa punya banyak TA (meski biasanya 1 yg aktif)
     */
    public function tugasAkhir(): BelongsToMany
    {
        // (Model, nama_tabel_pivot, foreign_key_model_ini, foreign_key_model_tujuan)
        return $this->belongsToMany(TugasAkhir::class, 'tugas_akhir_anggota', 'mhs_nim', 'tugas_akhir_id');
    }
}

