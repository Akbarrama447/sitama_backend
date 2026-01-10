<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        
       $mahasiswa = User::where('role', 'mahasiswa')
                     ->join('mahasiswa', 'users.id', '=', 'mahasiswa.user_id') // Gabungkan tabel
                     ->select(
                         'users.id', 
                         'users.name', 
                         'mahasiswa.mhs_nim as nim' // PENTING: Rename 'mhs_nim' jadi 'nim'
                     ) 
                     ->get();

    return response()->json($mahasiswa);
    }
}