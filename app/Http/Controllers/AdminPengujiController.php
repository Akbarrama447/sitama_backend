<?php

namespace App\Http\Controllers;

use App\Models\DosenPenguji;
use App\Models\Dosen;
use App\Models\SidangTugasAkhir;
use App\Models\TugasAkhir;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\DosenPengujiRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminPengujiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $penguji = DosenPenguji::getDosenPengujiForAdmin();


        return view('dosen-penguji.admin-index', compact('penguji'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $DosenPenguji = DosenPenguji::find($id);

        return view('admin-DosenPenguji.show', compact('DosenPenguji'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tugas_akhir = TugasAkhir::find($id);
        $sidang_tugas_akhir = SidangTugasAkhir::where('tugas_akhir_id', $id)->first();
        $penguji = DosenPenguji::where('sidang_id', $sidang_tugas_akhir->id)->get();
        $dosen = Dosen::all();


        return view('dosen-penguji.edit', compact('id', 'tugas_akhir', 'sidang_tugas_akhir','penguji', 'dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DosenPengujiRequest $request, DosenPenguji $DosenPenguji): RedirectResponse
    {
        $result = DB::table('dosen_penguji')->upsert(
            [
                ['sidang_id' => $request->get('sidang_id'), 'peran' => 1, 'dosen_nip' => $request->get('penguji_1'), 'created_at' => now(), 'updated_at' => now()],
                ['sidang_id' => $request->get('sidang_id'), 'peran' => 2, 'dosen_nip' => $request->get('penguji_2'), 'created_at' => now(), 'updated_at' => now()],
                ['sidang_id' => $request->get('sidang_id'), 'peran' => 3, 'dosen_nip' => $request->get('penguji_3'), 'created_at' => now(), 'updated_at' => now()],
            ],
            ['sidang_id', 'peran'], // Unique column(s)
            ['dosen_nip', 'updated_at'] // Columns to update on match
        );

        if ($result) {
            return Redirect::route('ta-penguji.index')
                ->with('success', 'DosenPenguji updated successfully');
        } else {
            return Redirect::route('ta-penguji.index')
                ->with('error', 'Gagal mengupdate DosenPenguji');
        }
    }

    public function destroy($id): RedirectResponse
    {
        DosenPenguji::find($id)->delete();

        return Redirect::route('ta-pembimbing.index')
            ->with('success', 'DosenPenguji deleted successfully');
    }
}
