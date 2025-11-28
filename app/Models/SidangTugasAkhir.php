<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SidangTugasAkhir extends Model
{
    protected $table = 'sidang_tugas_akhir';

    // Dynamically set fillable based on available columns
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (Schema::hasTable('sidang_tugas_akhir')) {
            $this->fillable = Schema::getColumnListing('sidang_tugas_akhir');
        }
    }

    // Relasi ke Tugas Akhir (untuk cek pembimbing)
    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class, 'tugas_akhir_id');
    }

    // Relasi ke mahasiswa melalui Tugas Akhir
    public function mahasiswa()
    {
        return $this->hasOneThrough(
            Mahasiswa::class,
            TugasAkhir::class,
            'id', // Foreign key on tugas_akhir table
            'mhs_nim', // Foreign key on mahasiswa table
            'tugas_akhir_id', // Local key on sidang_tugas_akhir table
            'mahasiswa_nim' // Local key on tugas_akhir table
        );
    }

    // Relasi ke nilai dosen pembimbing
    public function nilaiDosenPembimbing()
    {
        return $this->hasMany(NilaiDosenPembimbing::class, 'sidang_id');
    }

    // Relasi ke dosen penguji
    public function dosenPenguji()
    {
        if (Schema::hasTable('dosen_penguji')) {
            return $this->hasMany(DosenPenguji::class, 'sidang_id');
        } else {
            // If table doesn't exist, return a dummy relation
            return $this->hasMany(DosenPenguji::class, 'sidang_id')->whereRaw('1 = 0');
        }
    }

    // Relasi ke dosen pembimbing 1 (melalui tabel bimbingan)
    public function dosenPembimbing1()
    {
        return $this->belongsToMany(Dosen::class, 'bimbingan', 'tugas_akhir_id', 'dosen_nip')
            ->where('bimbingan.urutan', 1)
            ->whereHas('tugasAkhir.sidang', function($query) {
                $query->where('sidang_tugas_akhir.id', $this->id);
            });
    }

    // Relasi ke dosen pembimbing 2 (melalui tabel bimbingan)
    public function dosenPembimbing2()
    {
        return $this->belongsToMany(Dosen::class, 'bimbingan', 'tugas_akhir_id', 'dosen_nip')
            ->where('bimbingan.urutan', 2)
            ->whereHas('tugasAkhir.sidang', function($query) {
                $query->where('sidang_tugas_akhir.id', $this->id);
            });
    }

    // Alternatif relasi untuk mengakses pembimbing melalui tugas akhir (untuk backward compatibility)
    public function pembimbing()
    {
        return $this->hasManyThrough(
            Dosen::class,
            Bimbingan::class,
            'tugas_akhir_id', // foreign key on bimbingan table
            'dosen_nip',      // foreign key on dosen table
            'tugas_akhir_id', // local key on sidang_tugas_akhir table
            'dosen_nip'       // local key on bimbingan table
        );
    }

    // Relasi ke dosen penguji 1
    public function dosenPenguji1()
    {
        if (Schema::hasColumn('sidang_tugas_akhir', 'penguji_1_nip')) {
            return $this->belongsTo(Dosen::class, 'penguji_1_nip', 'dosen_nip');
        } else {
            // If column doesn't exist, return a dummy relation
            return $this->belongsTo(Dosen::class, 'penguji_1_nip', 'dosen_nip')->whereRaw('1 = 0');
        }
    }

    // Relasi ke dosen penguji 2
    public function dosenPenguji2()
    {
        if (Schema::hasColumn('sidang_tugas_akhir', 'penguji_2_nip')) {
            return $this->belongsTo(Dosen::class, 'penguji_2_nip', 'dosen_nip');
        } else {
            // If column doesn't exist, return a dummy relation
            return $this->belongsTo(Dosen::class, 'penguji_2_nip', 'dosen_nip')->whereRaw('1 = 0');
        }
    }

    // Relasi ke dosen penguji 3
    public function dosenPenguji3()
    {
        if (Schema::hasColumn('sidang_tugas_akhir', 'penguji_3_nip')) {
            return $this->belongsTo(Dosen::class, 'penguji_3_nip', 'dosen_nip');
        } else {
            // If column doesn't exist, return a dummy relation
            return $this->belongsTo(Dosen::class, 'penguji_3_nip', 'dosen_nip')->whereRaw('1 = 0');
        }
    }

    // Relasi ke sekretaris
    public function sekretaris()
    {
        if (Schema::hasColumn('sidang_tugas_akhir', 'sekretaris_nip')) {
            return $this->belongsTo(Dosen::class, 'sekretaris_nip', 'dosen_nip');
        } else {
            // If column doesn't exist, return a dummy relation
            return $this->belongsTo(Dosen::class, 'sekretaris_nip', 'dosen_nip')->whereRaw('1 = 0');
        }
    }

    // --- SCOPE: Mengambil semua jadwal yang berhubungan dengan NIP Dosen ---
    public function scopeTerkaitDosen(Builder $query, $dosenNip)
    {
        return $query->where(function($q) use ($dosenNip) {
            $pengujiColumnsExist = Schema::hasColumn('sidang_tugas_akhir', 'penguji_1_nip') &&
                                   Schema::hasColumn('sidang_tugas_akhir', 'penguji_2_nip');

            $sekretarisColumnExists = Schema::hasColumn('sidang_tugas_akhir', 'sekretaris_nip');

            // Cek apakah dia Penguji atau Sekretaris di tabel Sidang
            if ($pengujiColumnsExist) {
                $q->where('penguji_1_nip', $dosenNip)
                  ->orWhere('penguji_2_nip', $dosenNip);
            }

            if ($sekretarisColumnExists) {
                $q->orWhere('sekretaris_nip', $dosenNip);
            }

            // Cek apakah dia Pembimbing (via relasi Tugas Akhir)
            $q->orWhereHas('tugasAkhir', function($qTA) use ($dosenNip) {
                $qTA->where(function($subQ) use ($dosenNip) {
                    if (Schema::hasColumn('tugas_akhir', 'pembimbing_1_nip')) {
                        $subQ->where('pembimbing_1_nip', $dosenNip);
                    }
                    if (Schema::hasColumn('tugas_akhir', 'pembimbing_2_nip')) {
                        $subQ->orWhere('pembimbing_2_nip', $dosenNip);
                    }
                });
            });
        });
    }

    // Scope untuk mengambil data sidang terkait dengan dosen pembimbing
    public function scopeTerkaitDosenPembimbing(Builder $query, $dosenNip)
    {
        $hasPembimbingCols = Schema::hasColumn('tugas_akhir', 'pembimbing_1_nip') &&
                             Schema::hasColumn('tugas_akhir', 'pembimbing_2_nip');

        $query->join('tugas_akhir', 'sidang_tugas_akhir.tugas_akhir_id', '=', 'tugas_akhir.id')
            ->join('tugas_akhir_anggota', 'tugas_akhir.id', '=', 'tugas_akhir_anggota.tugas_akhir_id')
            ->join('mahasiswa', 'tugas_akhir_anggota.mhs_nim', '=', 'mahasiswa.mhs_nim')
            ->join('bimbingan', 'tugas_akhir.id', '=', 'bimbingan.tugas_akhir_id')
            ->leftJoin('nilai_dosen_pembimbing', function($join) use ($dosenNip) {
                $join->on('sidang_tugas_akhir.id', '=', 'nilai_dosen_pembimbing.sidang_id')
                     ->where('nilai_dosen_pembimbing.dosen_nip', '=', $dosenNip);
            })
            ->where('bimbingan.dosen_nip', $dosenNip);

        if ($hasPembimbingCols) {
            $query->select(
                'sidang_tugas_akhir.id as sidang_id',
                'sidang_tugas_akhir.status as status_jadwal',
                'tugas_akhir.judul',
                'mahasiswa.mhs_nama',
                'mahasiswa.mhs_nim',
                'nilai_dosen_pembimbing.nilai',
                'nilai_dosen_pembimbing.id as nilai_id'
            );
        } else {
            // Fallback select for when pembimbing columns don't exist
            $query->select(
                'sidang_tugas_akhir.id as sidang_id',
                'sidang_tugas_akhir.status as status_jadwal',
                DB::raw('NULL as judul'),
                'mahasiswa.mhs_nama',
                'mahasiswa.mhs_nim',
                'nilai_dosen_pembimbing.nilai',
                'nilai_dosen_pembimbing.id as nilai_id'
            );
        }

        return $query->distinct()
            ->orderBy('sidang_tugas_akhir.created_at', 'desc');
    }

    // --- ACCESSOR: Logic Pendeteksi Peran ---
    // Cara pakai di blade: $sidang->peran_saya
    public function getPeranSayaAttribute()
    {
        // Kita butuh NIP dosen yang sedang login
        // (Pastikan kamu sudah handle logic pengambilan NIP user yg login di global helper atau session)
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if(!$dosen) return null;
        $nip = $dosen->dosen_nip;

        // Check if columns exist before using them
        $sekretarisColExists = Schema::hasColumn('sidang_tugas_akhir', 'sekretaris_nip');
        $penguji1ColExists = Schema::hasColumn('sidang_tugas_akhir', 'penguji_1_nip');
        $penguji2ColExists = Schema::hasColumn('sidang_tugas_akhir', 'penguji_2_nip');

        // 1. Cek Sekretaris (Prioritas tertinggi/terendah tergantung aturan, biasanya aksesnya paling luas)
        if ($sekretarisColExists && $this->sekretaris_nip == $nip) {
            return 'sekretaris';
        }

        // 2. Cek Penguji
        if (($penguji1ColExists && $this->penguji_1_nip == $nip) ||
            ($penguji2ColExists && $this->penguji_2_nip == $nip)) {
            return 'penguji';
        }

        // 3. Cek Pembimbing (Harus load relasi tugasAkhir dulu)
        if ($this->tugasAkhir) {
            $pembimbing1Exists = Schema::hasColumn('tugas_akhir', 'pembimbing_1_nip');
            $pembimbing2Exists = Schema::hasColumn('tugas_akhir', 'pembimbing_2_nip');

            if (($pembimbing1Exists && $this->tugasAkhir->pembimbing_1_nip == $nip) ||
                ($pembimbing2Exists && $this->tugasAkhir->pembimbing_2_nip == $nip)) {
                return 'pembimbing';
            }
        }

        return 'guest'; // Atau error
    }

    // Static method to get sidang data related to a specific dosen as pembimbing
    public static function getSidangForDosenPembimbing($dosenNip)
    {
        return self::query()
            ->terkaitDosenPembimbing($dosenNip);
    }
}