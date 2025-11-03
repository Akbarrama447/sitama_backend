<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SidangController extends Controller
{
    public function index()
    {
        return view('dosen.sidang');
    }
}
