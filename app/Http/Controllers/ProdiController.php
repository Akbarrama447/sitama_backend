<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProdiRequest;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $prodis = Prodi::paginate();

        return view('prodi.index', compact('prodis'))
            ->with('i', ($request->input('page', 1) - 1) * $prodis->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $prodi = new Prodi();
        $jurusan = Jurusan::all();

        return view('prodi.create', compact('prodi', 'jurusan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdiRequest $request): RedirectResponse
    {
        Prodi::create($request->validated());

        return Redirect::route('prodi.index')
            ->with('success', 'Prodi created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $prodi = Prodi::find($id);

        return view('prodi.show', compact('prodi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $prodi = Prodi::find($id);
        $jurusan = Jurusan::all();

        return view('prodi.edit', compact('prodi','jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdiRequest $request, Prodi $prodi): RedirectResponse
    {
        $prodi->update($request->validated());

        return Redirect::route('prodi.index')
            ->with('success', 'Prodi updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Prodi::find($id)->delete();

        return Redirect::route('prodi.index')
            ->with('success', 'Prodi deleted successfully');
    }
}
