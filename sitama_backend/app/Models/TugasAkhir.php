<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    protected $table = 'tugas_akhir';
    protected $guarded = ['id'];

    public function mahasiswa()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'tugas_akhir_anggota',
            'tugas_akhir_id',
            'mhs_nim',
            'id',
            'mhs_nim'
        );
    }

    public function getMahasiswaAttribute()
    {
        if ($this->relationLoaded('mahasiswa')) {
            return $this->getRelation('mahasiswa')->first();
        }
        return $this->mahasiswa()->first();
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'tugas_akhir_id');
    }

    public function sidang()
    {
        return $this->hasOne(SidangTugasAkhir::class, 'tugas_akhir_id');
    }

    public function cekKelayakanSidang($mhs_nim) 
    {

        $minBimbingan = Config::getValue('min_bimbingan', 8);

        $ta = TugasAkhir::whereHas('mahasiswa', function($q) use ($mhs_nim) {
            $q->where('mhs_nim', $mhs_nim);
        })->first();

        $statusBimbingan = \DB::table('bimbingan')
            ->where('tugas_akhir_id', $ta->id)
            ->select('id', 'urutan')
            ->get()
            ->map(function($item) use ($minBimbingan) {
                $jumlahApproved = \DB::table('bimbingan_log')
                    ->where('bimbingan_id', $item->id)
                    ->where('status', 2) // Hanya yang disetujui
                    ->count();
                
                return [
                    'pembimbing_ke' => $item->urutan,
                    'jumlah' => $jumlahApproved,
                    'is_full' => $jumlahApproved >= $minBimbingan
                ];
            });

        // 4. Kesimpulan: Harus SEMUA pembimbing bernilai is_full = true
        $bolehSidang = $statusBimbingan->every('is_full', true);

        return [
            'boleh_sidang' => $bolehSidang,
            'detail' => $statusBimbingan
        ];

    }
}