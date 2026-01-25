<?php

namespace App\Http\Controllers;

use App\Models\SyaratSidang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SyaratSidangRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SyaratSidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        $syaratSidangs = SyaratSidang::paginate();

        return view('syarat-sidang.index', compact('syaratSidangs'))
            ->with('i', ($request->input('page', 1) - 1) * $syaratSidangs->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $syaratSidang = new SyaratSidang();

        return view('syarat-sidang.create', compact('syaratSidang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SyaratSidangRequest $request): RedirectResponse
    {
        SyaratSidang::create($request->validated());

        return Redirect::route('ta-approval.index')
            ->with('success', 'SyaratSidang created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $syaratSidang = SyaratSidang::find($id);

        return view('syarat-sidang.show', compact('syaratSidang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $syaratSidang = SyaratSidang::find($id);

        return view('syarat-sidang.edit', compact('syaratSidang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SyaratSidangRequest $request, $id): RedirectResponse
    {
        $syaratSidang = SyaratSidang::findOrFail($id);

        $oldVerified = $syaratSidang->verified;
        $newVerified = $request->verified;

        $syaratSidang->update($request->validated());

        // Refresh model untuk mendapatkan data terbaru
        $syaratSidang->refresh();

        // Log untuk debugging
        \Log::info('SyaratSidang updated', [
            'id' => $syaratSidang->id,
            'old_verified' => $oldVerified,
            'new_verified' => $newVerified,
            'final_verified' => $syaratSidang->verified
        ]);

        return Redirect::route('ta-approval.index')
            ->with('success', 'SyaratSidang updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        SyaratSidang::find($id)->delete();

        return Redirect::route('ta-approval.index')
            ->with('success', 'SyaratSidang deleted successfully');
    }
}
