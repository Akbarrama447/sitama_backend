<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenSidang extends Model
{
    protected $table = 'dokumen_sidang';
    protected $fillable = ['dokumen_syarat', 'dokumen_file', 'verified', 'keterangan', 'tipe_dokumen'];
    protected $guarded = ['dokumen_id'];

}
