<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bimbingan extends Model
{
    use HasFactory;

    protected $table = 'bimbingan';

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class, 'tugas_akhir_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'dosen_nip');
    }

    public function bimbinganLogs()
    {
        return $this->hasMany(BimbinganLog::class, 'bimbingan_id');
    }

    public function scopeWithMahasiswa($query)
    {
        return $query->join('tugas_akhir', 'bimbingan.tugas_akhir_id', '=', 'tugas_akhir.id')
            ->join('tugas_akhir_anggota', 'tugas_akhir.id', '=', 'tugas_akhir_anggota.tugas_akhir_id')
            ->join('mahasiswa', 'tugas_akhir_anggota.mhs_nim', '=', 'mahasiswa.mhs_nim');
    }

    public function scopeForDosen($query, $dosenNip)
    {
        return $query->where('bimbingan.dosen_nip', $dosenNip);
    }

    public function scopeWithLatestLog($query)
    {
        return $query->select(
            'tugas_akhir.id as ta_id',
            'tugas_akhir.judul as judul_ta',
            'tugas_akhir.tahun_akademik',
            'mahasiswa.mhs_nama',
            'mahasiswa.mhs_nim',
            'bimbingan.id as bimbingan_id',
            'bimbingan.urutan',
            DB::raw('(SELECT id FROM bimbingan_log WHERE bimbingan_log.bimbingan_id = bimbingan.id ORDER BY tanggal DESC LIMIT 1) as id'),
            DB::raw('(SELECT tanggal FROM bimbingan_log WHERE bimbingan_log.bimbingan_id = bimbingan.id ORDER BY tanggal DESC LIMIT 1) as tanggal'),
            DB::raw('(SELECT catatan FROM bimbingan_log WHERE bimbingan_log.bimbingan_id = bimbingan.id ORDER BY tanggal DESC LIMIT 1) as catatan'),
            DB::raw('(SELECT status FROM bimbingan_log WHERE bimbingan_log.bimbingan_id = bimbingan.id ORDER BY tanggal DESC LIMIT 1) as status'),
            DB::raw('(SELECT COUNT(*) FROM bimbingan_log WHERE bimbingan_log.bimbingan_id = bimbingan.id AND bimbingan_log.status = 2) as jumlah_verified')
        );
    }

    public function scopeWithVerifiedLogs($query)
    {
        return $query->whereExists(function ($subquery) {
            $subquery->select(DB::raw(1))
                ->from('bimbingan_log')
                ->whereColumn('bimbingan_log.bimbingan_id', 'bimbingan.id');
        });
    }

    public function scopeWithGroupedByTa($query)
    {
        return $query->groupBy('tugas_akhir.id');
    }

    public function scopeOrderByMahasiswaName($query)
    {
        return $query->orderBy('mahasiswa.mhs_nama', 'asc');
    }

    // Static method to get all bimbingan data for a specific dosen
    public static function getBimbinganForDosen($dosenNip)
    {
        return self::query()
            ->withMahasiswa()
            ->forDosen($dosenNip)
            ->withVerifiedLogs()
            ->withLatestLog()
            ->withGroupedByTa()
            ->orderByMahasiswaName();
    }

    public static function getBimbinganForAdmin()
    {
        $results = DB::select("SELECT
                        A.id,
                        A.judul,
                        GROUP_CONCAT(DISTINCT(B.mhs_nama) SEPARATOR ', ') mahasiswa,
                        GROUP_CONCAT(DISTINCT(CONCAT(C.urutan,'. ',D.dosen_nama)) ORDER BY C.urutan SEPARATOR '<br>') pembimbing
                    FROM tugas_akhir A
                    JOIN tugas_akhir_anggota AA
                        ON A.id = AA.tugas_akhir_id
                    JOIN mahasiswa B
                        ON AA.mhs_nim = B.mhs_nim
                    LEFT JOIN bimbingan C
                        ON A.id = C.tugas_akhir_id
                    LEFT JOIN dosen D
                        ON C.dosen_nip = D.dosen_nip
                    GROUP BY A.id;", []);

        return $results;
    }
}
