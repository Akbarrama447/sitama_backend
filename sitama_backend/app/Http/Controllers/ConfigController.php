<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        // Halaman konfigurasi bisa ditambahkan di sini
        // Untuk sekarang, hanya menampilkan view kosong atau redirect
        return view('config.index'); // atau bisa juga return redirect()->back();
    }
}