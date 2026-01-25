<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminProdi
 *
 * @property $id
 * @property $user_id
 * @property $prodi_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Prodi $prodi
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AdminProdi extends Model
{
    
    protected $table = "admin_prodi";

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'prodi_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prodi()
    {
        return $this->belongsTo(\App\Models\Prodi::class, 'prodi_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
}
