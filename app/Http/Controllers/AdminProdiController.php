<?php

namespace App\Http\Controllers;

use App\Models\AdminProdi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AdminProdiRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $adminProdis = AdminProdi::paginate();

        return view('admin-prodi.index', compact('adminProdis'))
            ->with('i', ($request->input('page', 1) - 1) * $adminProdis->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $adminProdi = new AdminProdi();

        return view('admin-prodi.create', compact('adminProdi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminProdiRequest $request): RedirectResponse
    {
        AdminProdi::create($request->validated());

        return Redirect::route('prodi-admin..index')
            ->with('success', 'AdminProdi created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $adminProdi = AdminProdi::find($id);

        return view('admin-prodi.show', compact('adminProdi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $adminProdi = AdminProdi::find($id);

        return view('admin-prodi.edit', compact('adminProdi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminProdiRequest $request, AdminProdi $adminProdi): RedirectResponse
    {
        $adminProdi->update($request->validated());

        return Redirect::route('prodi-admin..index')
            ->with('success', 'AdminProdi updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        AdminProdi::find($id)->delete();

        return Redirect::route('prodi-admin..index')
            ->with('success', 'AdminProdi deleted successfully');
    }
}
