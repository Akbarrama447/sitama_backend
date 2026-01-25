<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DosenPenguji extends Model
{
    use HasFactory;

    protected $table = 'dosen_penguji';

    // Dynamically set fillable based on available columns
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (Schema::hasTable('dosen_penguji')) {
            $this->fillable = Schema::getColumnListing('dosen_penguji');
        } else {
            // Default fillable if table doesn't exist
            $this->fillable = ['sidang_id', 'dosen_nip', 'peran'];
        }
    }

    public function sidang()
    {
        return $this->belongsTo(SidangTugasAkhir::class, 'sidang_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip', 'dosen_nip');
    }

    public static function getDosenPengujiForAdmin(){
        $results = DB::select("SELECT
                        A.id,
                        A.judul,
                        GROUP_CONCAT(DISTINCT(B.mhs_nama) SEPARATOR ', ') mahasiswa,
                        GROUP_CONCAT(DISTINCT(CONCAT(F.peran,'. ',D.dosen_nama)) ORDER BY F.peran SEPARATOR '<br>') pembimbing
                    FROM tugas_akhir A
                        JOIN tugas_akhir_anggota AA
                            ON A.id = AA.tugas_akhir_id
                        JOIN mahasiswa B
                            ON AA.mhs_nim = B.mhs_nim
                        JOIN sidang_tugas_akhir E
                            ON A.id = E.tugas_akhir_id
                        JOIN dosen_penguji F
                            ON E.id = F.sidang_id
                        LEFT JOIN dosen D
                            ON F.dosen_nip = D.dosen_nip
                        GROUP BY A.id;", []);

        return $results;

    }
}
