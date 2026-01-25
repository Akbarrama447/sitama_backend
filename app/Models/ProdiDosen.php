<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProdiDosen
 *
 * @property $id
 * @property $prodi_id
 * @property $dosen_nip
 * @property $created_at
 * @property $updated_at
 *
 * @property Dosen $dosen
 * @property Prodi $prodi
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ProdiDosen extends Model
{
    
    protected $table = "prodi_dosen";

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['prodi_id', 'dosen_nip'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo(\App\Models\Dosen::class, 'dosen_nip', 'dosen_nip');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prodi()
    {
        return $this->belongsTo(\App\Models\Prodi::class, 'prodi_id', 'id');
    }
    
}
