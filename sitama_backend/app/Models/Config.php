<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'configs';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'setting_key',
        'setting_label',
        'setting_type',
        'setting_value',
        'is_visible'
    ];

    /**
     * Helper Static Method: Mengambil nilai berdasarkan key
     * Contoh penggunaan: Config::getValue('min_bimbingan')
     */
    public static function getValue($key, $default = null)
    {
        $config = self::where('setting_key', $key)->first();
        return $config ? $config->setting_value : $default;
    }
}