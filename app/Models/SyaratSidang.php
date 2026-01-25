<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class SyaratSidang
 *
 * @property $id
 * @property $tugas_akhir_id
 * @property $dokumen_id
 * @property $mhs_nim
 * @property $dokumen_file_original
 * @property $dokumen_file
 * @property $verified
 * @property $tanggal_upload
 *
 * @property Mahasiswa $mahasiswa
 * @property DokumenSidang $dokumenSidang
 * @property TugasAkhir $tugasAkhir
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SyaratSidang extends Model
{

    public $timestamps = false;
    protected $table = 'syarat_sidang';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['tugas_akhir_id', 'dokumen_id', 'mhs_nim', 'dokumen_file_original', 'dokumen_file', 'verified', 'tanggal_upload'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mahasiswa()
    {
        return $this->belongsTo(\App\Models\Mahasiswa::class, 'mhs_nim', 'mhs_nim');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dokumenSidang()
    {
        return $this->belongsTo(\App\Models\DokumenSidang::class, 'dokumen_id', 'dokumen_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tugasAkhir()
    {
        return $this->belongsTo(\App\Models\TugasAkhir::class, 'tugas_akhir_id', 'id');
    }

    public function approval(){
        return DB::select("
            SELECT
        ",[]);
    }

}
