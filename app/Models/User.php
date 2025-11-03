<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <-- 1. TAMBAHKAN INI

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // <-- 2. TAMBAHKAN HasApiTokens DI SINI

    /**
     * Memberitahu Laravel nama tabel yang benar untuk model ini.
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mendefinisikan relasi bahwa satu User memiliki satu data Mahasiswa.
     */
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }

    /**
     * Mendefinisikan relasi bahwa satu User memiliki satu data Dosen.
     */
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'user_id');
    }
}

