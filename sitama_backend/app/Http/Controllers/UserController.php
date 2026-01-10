<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read_user')->only('index', 'show');
        $this->middleware('permission:create_user')->only('create', 'store');
        $this->middleware('permission:update_user')->only('edit', 'update');
        $this->middleware('permission:delete_user')->only('destroy');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email:rfc|unique:user',
            'role' => 'nullable',
            'verified' => 'nullable|string',
            'password' => 'required|min:6', // Password wajib saat create
        ]);

        if ($validator->fails()) {
            toastr()->error('Pengguna gagal ditambah </br> Periksa kembali data anda');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            // Assign Role (Ambil ID atau Array kosong)
            $roleIds = $request->role ?? [];

            $roles = Role::whereIn('id', $roleIds)->get();

            $user->syncRoles($roles);

            toastr()->success('Pengguna baru berhasil disimpan');
            return redirect()->route('manage-user.index');
        } catch (\Throwable $th) {
            toastr()->warning('Server Error: ' . $th->getMessage());
            return redirect()->route('manage-user.index');
        }
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id); // Pakai findOrFail standar
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email:rfc|unique:user,email,'.$id, 
            'role' => 'nullable',
            'verified' => 'nullable', 
            'password' => 'nullable|min:6', 
        ]);

        if ($validator->fails()) {
            toastr()->error('Pengguna gagal diperbarui </br> Periksa kembali data anda');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };

        try {
            $user = User::findOrFail($id);

            // 1. Siapkan data tanpa password dulu
            $update_data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            // 2. Cek apakah user input password baru?
            // PERBAIKAN: Hanya masukkan password ke array jika user mengisinya
            if ($request->filled('password')) {
                $update_data['password'] = Hash::make($request->password);
            }

            // 3. Eksekusi Update
            $user->update($update_data);

            // 4. Sync Roles
            $roleIds = $request->role ?? []; 
            
            // Cari Object Role berdasarkan ID tersebut
            $roles = Role::whereIn('id', $roleIds)->get();
            
            // Masukkan Object Role (bukan ID) ke Spatie
            $user->syncRoles($roles);
            
            toastr()->success('Pengguna berhasil diperbarui');
            return redirect()->route('manage-user.index');
        
        } catch (\Throwable $th) {
            // Tampilkan pesan error asli biar ketahuan salahnya dimana
            toastr()->warning('Server Error: ' . $th->getMessage());
            return redirect()->route('manage-user.index');
        }
    }

    public function destroy($id)
    {
        //
    }
}