<?php

namespace App\Models\ModelApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\ModelApi\DokumenSidang; // Tambahkan import ini untuk method syaratSidangLengkap
use App\Models\ModelApi\SyaratSidang; // Tambahkan import ini untuk relasi syaratSidang
use App\Models\ModelApi\Bimbingan;
use App\Models\ModelApi\TugasAkhirAnggota;
use App\Models\ModelApi\Mahasiswa;
use App\Models\ModelApi\SidangTugasAkhir;
use App\Models\ModelApi\LogBimbingan; // Tambahkan import ini untuk method semuaAnggotaSelesaiBimbingan
use App\Models\Config; // Tambahkan import ini untuk mengakses konfigurasi

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
     * Relasi ke SidangTugasAkhir (untuk ambil sidang terkait tugas akhir).
     */
    public function sidangTugasAkhir(): HasMany
    {
        return $this->hasMany(SidangTugasAkhir::class, 'tugas_akhir_id', 'id');
    }

    /**
     * Relasi ke SyaratSidang (untuk cek kelengkapan dokumen sidang).
     */
    public function syaratSidang(): HasMany
    {
        return $this->hasMany(SyaratSidang::class, 'tugas_akhir_id', 'id');
    }

    /**
     * Method untuk mengecek apakah syarat sidang sudah lengkap.
     * Syarat sidang dianggap lengkap jika semua dokumen WAJIB yang diperlukan
     * telah diupload dan disetujui (verified = 1).
     *
     * @return bool
     */
    public function syaratSidangLengkap(): bool
    {
        // Ambil semua dokumen wajib untuk sidang (berdasarkan tabel dokumen_sidang)
        $dokumenWajib = DokumenSidang::all();

        // Jika ga ada dokumen wajib di sistem, anggap lengkap
        if ($dokumenWajib->isEmpty()) {
            return true;
        }

        $totalDokumenWajib = $dokumenWajib->count();

        // Ambil semua syarat sidang yang udah diupload oleh mahasiswa ini
        $syaratUdahDiupload = $this->syaratSidang()->get();

        // Hitung berapa banyak dokumen wajib yang udah disetujui
        $dokumenLengkap = 0;
        foreach ($dokumenWajib as $dokumenWajibItem) {
            // Cek apakah dokumen ini udah diupload dan disetujui oleh mahasiswa
            $dokumenIniDisetujui = $syaratUdahDiupload->contains(function ($syarat) use ($dokumenWajibItem) {
                return $syarat->dokumen_id === $dokumenWajibItem->dokumen_id && $syarat->verified == 1;
            });

            if ($dokumenIniDisetujui) {
                $dokumenLengkap++;
            }
        }

        // Syarat sidang lengkap kalau semua dokumen wajib udah verified
        return $dokumenLengkap === $totalDokumenWajib;
    }

    /**
     * Method untuk mengecek apakah semua anggota dalam kelompok Tugas Akhir
     * sudah selesai bimbingan (minimal jumlah log bimbingan disetujui sesuai konfigurasi).
     *
     * @return bool
     */
    public function semuaAnggotaSelesaiBimbingan(): bool
    {
        // Ambil nilai minimal bimbingan dari konfigurasi, default ke 2 jika tidak ditemukan
        $minBimbingan = (int) Config::getValue('min_bimbingan', 2);

        // Ambil semua anggota kelompok
        $anggotaKelompok = $this->mahasiswa()->get();

        // Jika tidak ada anggota, anggap belum selesai
        if ($anggotaKelompok->isEmpty()) {
            return false;
        }

        // Cek setiap anggota apakah jumlah log bimbingan yang disetujui sudah mencapai minimum
        foreach ($anggotaKelompok as $anggota) {
            // Ambil jumlah log bimbingan yang disetujui milik anggota ini untuk tugas akhir ini
            $jumlahLogDisetujui = LogBimbingan::whereHas('bimbingan', function ($query) {
                    $query->where('tugas_akhir_id', $this->id);
                })
                ->where('mhs_nim', $anggota->mhs_nim)
                ->whereIn('status', [1, 2]) // Status 1 = disetujui, 2 = disetujui (sesuai dengan data di database)
                ->count();

            // Debug: Log jumlah log bimbingan per anggota
            \Log::info("TA ID: {$this->id}, Anggota: {$anggota->mhs_nim}, Jumlah log disetujui: {$jumlahLogDisetujui}, Minimal: {$minBimbingan}");

            // Jika jumlah log bimbingan yang disetujui kurang dari minimum, anggap belum selesai
            if ($jumlahLogDisetujui < $minBimbingan) {
                return false;
            }
        }

        // Jika semua anggota sudah memiliki minimal jumlah log bimbingan yang disetujui, kembalikan true
        return true;
    }
}