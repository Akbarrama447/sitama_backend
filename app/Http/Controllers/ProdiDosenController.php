<?php

namespace App\Http\Controllers;

use App\Models\ProdiDosen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProdiDosenRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProdiDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $prodiDosens = ProdiDosen::paginate();

        return view('prodi-dosen.index', compact('prodiDosens'))
            ->with('i', ($request->input('page', 1) - 1) * $prodiDosens->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $prodiDosen = new ProdiDosen();

        return view('prodi-dosen.create', compact('prodiDosen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdiDosenRequest $request): RedirectResponse
    {
        ProdiDosen::create($request->validated());

        return Redirect::route('prodi-dosen.index')
            ->with('success', 'ProdiDosen created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $prodiDosen = ProdiDosen::find($id);

        return view('prodi-dosen.show', compact('prodiDosen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $prodiDosen = ProdiDosen::find($id);

        return view('prodi-dosen.edit', compact('prodiDosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdiDosenRequest $request, ProdiDosen $prodiDosen): RedirectResponse
    {
        $prodiDosen->update($request->validated());

        return Redirect::route('prodi-dosen.index')
            ->with('success', 'ProdiDosen updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        ProdiDosen::find($id)->delete();

        return Redirect::route('prodi-dosen.index')
            ->with('success', 'ProdiDosen deleted successfully');
    }
}
