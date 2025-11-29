<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany as ModelHasMany;

class TugasAkhir extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'tugas_akhir';

    //
    // --- INI SOLUSINYA ---
    //
    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'status',
        'tahun_akademik',
    ];
    // --- SELESAI ---
    //


    /**
     * Relasi ke Bimbingan (untuk ambil dosen pembimbing).
     */
    public function bimbingan(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'tugas_akhir_id', 'id');
    }

    public function anggota(): HasMany
    {
        return $this->hasMany(TugasAkhirAnggota::class, 'tugas_akhir_id');
    }

    /**
     * Relasi ke Mahasiswa (untuk ambil anggota kelompok).
     */
    public function mahasiswa(): BelongsToMany
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'tugas_akhir_anggota', // Nama tabel pivot
            'tugas_akhir_id',     // Foreign key di pivot untuk model ini
            'mhs_nim'             // Foreign key di pivot untuk model Mahasiswa
        );
    }

    /**
     * Relasi ke SyaratSidang
     */
    public function syaratSidang(): ModelHasMany
    {
        return $this->hasMany(SyaratSidang::class, 'tugas_akhir_id', 'id');
    }

    /**
     * Fungsi buat cek apakah semua syarat sidang udah lengkap dan terverifikasi
     *
     * @return bool
     */
    public function syaratSidangLengkap(): bool
    {
        // Hitung total syarat sidang yang harus dipenuhi (misal: 8 surat)
        $totalSyarat = 8;

        // Hitung jumlah syarat sidang yang udah diterima untuk TA ini
        $jumlahSyaratDiterima = $this->syaratSidang()
            ->where('status', 'Diterima')
            ->count();

        // Kembalikan true jika semua syarat udah lengkap dan terverifikasi
        return $jumlahSyaratDiterima >= $totalSyarat;
    }
}

