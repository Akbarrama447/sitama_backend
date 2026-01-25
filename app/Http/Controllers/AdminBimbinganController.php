<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\TugasAkhir;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\BimbinganRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminBimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
//        $bimbingans = Bimbingan::groupBy('tugas_akhir_id')->paginate();
        $bimbingans = Bimbingan::getBimbinganForAdmin();


        return view('bimbingan.admin-index', compact('bimbingans'));
//        return view('bimbingan.admin-index', compact('bimbingans'))
//            ->with('i', ($request->input('page', 1) - 1) * $bimbingans->perPage());
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $bimbingan = Bimbingan::find($id);

        return view('admin-bimbingan.show', compact('bimbingan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tugas_akhir = TugasAkhir::find($id);
        $bimbingan = Bimbingan::where('tugas_akhir_id', $id)->get();
        $dosen = Dosen::all();

        return view('bimbingan.edit', compact('id', 'tugas_akhir', 'bimbingan', 'dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BimbinganRequest $request, Bimbingan $bimbingan): RedirectResponse
    {
        $result = DB::table('bimbingan')->upsert(
            [
                ['tugas_akhir_id' => $request->get('tugas_akhir_id'), 'urutan' => 1, 'dosen_nip' => $request->get('pembimbing_1'), 'created_at' => now(), 'updated_at' => now()],
                ['tugas_akhir_id' => $request->get('tugas_akhir_id'), 'urutan' => 2, 'dosen_nip' => $request->get('pembimbing_2'), 'created_at' => now(), 'updated_at' => now()],
            ],
            ['tugas_akhir_id', 'urutan'], // Unique column(s)
            ['dosen_nip', 'updated_at'] // Columns to update on match
        );

        if ($result) {
            return Redirect::route('ta-pembimbing.index')
                ->with('success', 'Bimbingan updated successfully');
        } else {
            return Redirect::route('ta-pembimbing.index')
                ->with('error', 'Gagal mengupdate bimbingan');
        }
    }

    public function destroy($id): RedirectResponse
    {
        Bimbingan::find($id)->delete();

        return Redirect::route('ta-pembimbing.index')
            ->with('success', 'Bimbingan deleted successfully');
    }
}
