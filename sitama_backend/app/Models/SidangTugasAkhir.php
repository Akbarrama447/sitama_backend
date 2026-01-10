<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SidangTugasAkhir extends Model
{
    use HasFactory;

    protected $table = 'sidang_tugas_akhir';
    protected $guarded = ['id'];

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class, 'tugas_akhir_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalSidang::class, 'jadwal_sidang_id')->withDefault();
    }

    public function dosenPengujis()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_penguji', 'sidang_id', 'dosen_nip', 'id', 'dosen_nip')
                    ->withPivot('peran')
                    ->orderByPivot('peran', 'asc');
    }

    public function sekretaris()
    {
        return $this->belongsTo(Dosen::class, 'sekretaris_nip', 'dosen_nip');
    }

    public function getInfoJadwalAttribute()
    {
        if (!$this->relationLoaded('jadwal')) {
            $this->load('jadwal.sesi');
        }

        $jadwal = $this->jadwal;

        $data = [
            'hari_tgl' => '-',
            'waktu'    => 'Belum Dijadwalkan',
            'ruangan'  => '-',
            'sesi'     => '-'
        ];

        if ($jadwal && $jadwal->tanggal) {
            Carbon::setLocale('id');
            $date = is_string($jadwal->tanggal) ? Carbon::parse($jadwal->tanggal) : $jadwal->tanggal;

            $data['hari_tgl'] = $date->translatedFormat('l, d F Y');
            $data['ruangan']  = 'Ruangan ' . ($jadwal->ruangan_id ?? '-');

            if ($jadwal->sesi) {
                $mulai = substr($jadwal->sesi->waktu_mulai, 0, 5);
                $selesai = substr($jadwal->sesi->waktu_selesai, 0, 5);
                $data['waktu'] = "$mulai - $selesai";
                $data['sesi']  = $jadwal->sesi->nama_sesi;
            }
        }

        return $data;
    }

    public function getPeranDosen($nip)
    {
        if ($this->sekretaris_nip === $nip) {
            return 'Sekretaris';
        }

        $isPembimbing = $this->tugasAkhir->bimbingan()
                             ->where('dosen_nip', $nip)
                             ->first();

        if ($isPembimbing) return 'Pembimbing ' . $isPembimbing->urutan;

        $penguji = $this->dosenPengujis->where('dosen_nip', $nip)->first();
        if ($penguji) return $penguji->pivot->peran;

        return 'Tidak Ada';
    }
}