<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\JurusanRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $jurusans = Jurusan::paginate();

        return view('jurusan.index', compact('jurusans'))
            ->with('i', ($request->input('page', 1) - 1) * $jurusans->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $jurusan = new Jurusan();

        return view('jurusan.create', compact('jurusan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JurusanRequest $request): RedirectResponse
    {
        Jurusan::create($request->validated());

        return Redirect::route('jurusan.index')
            ->with('success', 'Jurusan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $jurusan = Jurusan::find($id);

        return view('jurusan.show', compact('jurusan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $jurusan = Jurusan::find($id);

        return view('jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JurusanRequest $request, Jurusan $jurusan): RedirectResponse
    {
        $jurusan->update($request->validated());

        return Redirect::route('jurusan.index')
            ->with('success', 'Jurusan updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Jurusan::find($id)->delete();

        return Redirect::route('jurusan.index')
            ->with('success', 'Jurusan deleted successfully');
    }
}
