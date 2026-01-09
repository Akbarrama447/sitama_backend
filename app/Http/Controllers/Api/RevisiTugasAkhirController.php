<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RevisiTugasAkhir;
use App\Models\TugasAkhir;
use App\Models\Dosen;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RevisiTugasAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        $query = RevisiTugasAkhir::query();

        // Filter by mhs_nim agar hanya menampilkan revisi milik user yang login
        $query->where('mhs_nim', $mahasiswa->mhs_nim);

        // Filter by tugas_akhir_id if provided
        if ($request->has('tugas_akhir_id')) {
            $query->where('tugas_akhir_id', $request->tugas_akhir_id);
        }

        // Filter by dosen_nip if provided
        if ($request->has('dosen_nip')) {
            $query->where('dosen_nip', $request->dosen_nip);
        }

        // Filter by status_revisi if provided
        if ($request->has('status_revisi')) {
            $query->where('status_revisi', $request->status_revisi);
        }

        $revisiTugasAkhir = $query->with(['tugasAkhir', 'dosen', 'mahasiswa'])->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $revisiTugasAkhir
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        $rules = [
            'dosen_nip' => 'required|exists:dosen,dosen_nip',
            'catatan_revisi' => 'required|string',
            'status_revisi' => 'required|integer'
        ];

        // Jika tugas_akhir_id tidak disediakan, kita akan coba deteksi otomatis
        if ($request->has('tugas_akhir_id')) {
            $rules['tugas_akhir_id'] = 'required|exists:tugas_akhir,id';
        }

        // Tambahkan validasi untuk file jika ada
        if ($request->hasFile('file_revisi')) {
            $rules['file_revisi'] = 'file|mimes:pdf,doc,docx,zip,rar|max:10240'; // max 10MB
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Deteksi tugas_akhir_id otomatis jika tidak disediakan
        $tugasAkhirId = $request->tugas_akhir_id;
        if (!$tugasAkhirId) {
            // Cek apakah user punya tugas akhir aktif
            $tugasAkhir = DB::table('mahasiswa')
                ->join('tugas_akhir_anggota', 'mahasiswa.mhs_nim', '=', 'tugas_akhir_anggota.mhs_nim')
                ->join('tugas_akhir', 'tugas_akhir_anggota.tugas_akhir_id', '=', 'tugas_akhir.id')
                ->where('mahasiswa.user_id', $user->id)
                ->where('tugas_akhir.status', '!=', 'Selesai')  // Hanya tugas akhir yang aktif
                ->select('tugas_akhir.id')
                ->first();

            if (!$tugasAkhir) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki tugas akhir aktif'
                ], 404);
            }

            $tugasAkhirId = $tugasAkhir->id;
        } else {
            // Jika tugas_akhir_id disediakan, cek apakah user memiliki akses ke tugas akhir tersebut
            $hasAccess = DB::table('mahasiswa')
                ->join('tugas_akhir_anggota', 'mahasiswa.mhs_nim', '=', 'tugas_akhir_anggota.mhs_nim')
                ->join('tugas_akhir', 'tugas_akhir_anggota.tugas_akhir_id', '=', 'tugas_akhir.id')
                ->where('mahasiswa.user_id', $user->id)
                ->where('tugas_akhir.id', $tugasAkhirId)
                ->exists();

            if (!$hasAccess) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses ke tugas akhir ini'
                ], 403);
            }
        }

        $data = $validator->validated();
        $data['tugas_akhir_id'] = $tugasAkhirId;
        $data['mhs_nim'] = $mahasiswa->mhs_nim; // Tambahkan nim mahasiswa yang membuat revisi

        // Handle file upload jika ada
        if ($request->hasFile('file_revisi')) {
            $file = $request->file('file_revisi');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('revisi_tugas_akhir', $fileName, 'public');
            $data['file_revisi'] = $filePath;
        }

        $revisiTugasAkhir = RevisiTugasAkhir::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Revisi Tugas Akhir created successfully',
            'data' => $revisiTugasAkhir->load(['tugasAkhir', 'dosen', 'mahasiswa'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        // Cek apakah revisi milik user yang login
        $revisiTugasAkhir = RevisiTugasAkhir::with(['tugasAkhir', 'dosen', 'mahasiswa'])
            ->where('id', $id)
            ->where('mhs_nim', $mahasiswa->mhs_nim)
            ->first();

        if (!$revisiTugasAkhir) {
            return response()->json([
                'status' => 'error',
                'message' => 'Revisi tidak ditemukan atau Anda tidak memiliki akses'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $revisiTugasAkhir
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        // Cek apakah revisi milik user yang login
        $revisiTugasAkhir = RevisiTugasAkhir::with('tugasAkhir')
            ->where('id', $id)
            ->where('mhs_nim', $mahasiswa->mhs_nim)
            ->first();

        if (!$revisiTugasAkhir) {
            return response()->json([
                'status' => 'error',
                'message' => 'Revisi tidak ditemukan atau Anda tidak memiliki akses'
            ], 404);
        }

        $rules = [
            'dosen_nip' => 'sometimes|required|exists:dosen,dosen_nip',
            'catatan_revisi' => 'sometimes|required|string',
            'status_revisi' => 'sometimes|required|integer'
        ];

        // Tambahkan validasi untuk tugas_akhir_id jika disediakan
        if ($request->has('tugas_akhir_id')) {
            $rules['tugas_akhir_id'] = 'sometimes|required|exists:tugas_akhir,id';
        }

        // Tambahkan validasi untuk file jika ada
        if ($request->hasFile('file_revisi')) {
            $rules['file_revisi'] = 'file|mimes:pdf,doc,docx,zip,rar|max:10240'; // max 10MB
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Handle file upload jika ada
        if ($request->hasFile('file_revisi')) {
            // Hapus file lama jika ada
            if ($revisiTugasAkhir->file_revisi) {
                Storage::disk('public')->delete($revisiTugasAkhir->file_revisi);
            }

            $file = $request->file('file_revisi');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('revisi_tugas_akhir', $fileName, 'public');
            $data['file_revisi'] = $filePath;
        }

        $revisiTugasAkhir->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Revisi Tugas Akhir updated successfully',
            'data' => $revisiTugasAkhir->load(['tugasAkhir', 'dosen', 'mahasiswa'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        // Cek apakah revisi milik user yang login
        $revisiTugasAkhir = RevisiTugasAkhir::where('id', $id)
            ->where('mhs_nim', $mahasiswa->mhs_nim)
            ->first();

        if (!$revisiTugasAkhir) {
            return response()->json([
                'status' => 'error',
                'message' => 'Revisi tidak ditemukan atau Anda tidak memiliki akses'
            ], 404);
        }

        // Hapus file jika ada
        if ($revisiTugasAkhir->file_revisi) {
            Storage::disk('public')->delete($revisiTugasAkhir->file_revisi);
        }

        $revisiTugasAkhir->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Revisi Tugas Akhir deleted successfully'
        ]);
    }

    /**
     * Get all revisions for a specific task
     */
    public function getByTugasAkhir(Request $request, $tugas_akhir_id)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        $tugasAkhir = TugasAkhir::findOrFail($tugas_akhir_id);

        // Cek apakah user memiliki akses ke tugas akhir ini
        $hasAccess = DB::table('mahasiswa')
            ->join('tugas_akhir_anggota', 'mahasiswa.mhs_nim', '=', 'tugas_akhir_anggota.mhs_nim')
            ->where('mahasiswa.user_id', $user->id)
            ->where('tugas_akhir_anggota.tugas_akhir_id', $tugas_akhir_id)
            ->exists();

        if (!$hasAccess) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses ke tugas akhir ini'
            ], 403);
        }

        $revisiTugasAkhir = RevisiTugasAkhir::where('tugas_akhir_id', $tugas_akhir_id)
            ->where('mhs_nim', $mahasiswa->mhs_nim) // Hanya revisi milik user yang login
            ->with(['tugasAkhir', 'dosen', 'mahasiswa'])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $revisiTugasAkhir
        ]);
    }

    /**
     * Store a newly created resource in storage (auto-detected tugas akhir)
     */
    public function storeForCurrentUser(Request $request)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        $rules = [
            'dosen_nip' => 'required|exists:dosen,dosen_nip',
            'catatan_revisi' => 'required|string',
            'status_revisi' => 'required|integer'
        ];

        // Tambahkan validasi untuk file jika ada
        if ($request->hasFile('file_revisi')) {
            $rules['file_revisi'] = 'file|mimes:pdf,doc,docx,zip,rar|max:10240'; // max 10MB
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Deteksi tugas_akhir_id otomatis
        $tugasAkhir = DB::table('mahasiswa')
            ->join('tugas_akhir_anggota', 'mahasiswa.mhs_nim', '=', 'tugas_akhir_anggota.mhs_nim')
            ->join('tugas_akhir', 'tugas_akhir_anggota.tugas_akhir_id', '=', 'tugas_akhir.id')
            ->where('mahasiswa.user_id', $user->id)
            ->where('tugas_akhir.status', '!=', 'Selesai')  // Hanya tugas akhir yang aktif
            ->select('tugas_akhir.id')
            ->first();

        if (!$tugasAkhir) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki tugas akhir aktif'
            ], 404);
        }

        $data = $validator->validated();
        $data['tugas_akhir_id'] = $tugasAkhir->id;
        $data['mhs_nim'] = $mahasiswa->mhs_nim; // Tambahkan nim mahasiswa yang membuat revisi

        // Handle file upload jika ada
        if ($request->hasFile('file_revisi')) {
            $file = $request->file('file_revisi');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('revisi_tugas_akhir', $fileName, 'public');
            $data['file_revisi'] = $filePath;
        }

        $revisiTugasAkhir = RevisiTugasAkhir::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Revisi Tugas Akhir created successfully',
            'data' => $revisiTugasAkhir->load(['tugasAkhir', 'dosen', 'mahasiswa'])
        ], 201);
    }

    /**
     * Get all revisions for current user's active tugas akhir
     */
    public function getForCurrentUser(Request $request)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        // Deteksi tugas_akhir_id otomatis
        $tugasAkhir = DB::table('mahasiswa')
            ->join('tugas_akhir_anggota', 'mahasiswa.mhs_nim', '=', 'tugas_akhir_anggota.mhs_nim')
            ->join('tugas_akhir', 'tugas_akhir_anggota.tugas_akhir_id', '=', 'tugas_akhir.id')
            ->where('mahasiswa.user_id', $user->id)
            ->where('tugas_akhir.status', '!=', 'Selesai')  // Hanya tugas akhir yang aktif
            ->select('tugas_akhir.id')
            ->first();

        if (!$tugasAkhir) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki tugas akhir aktif'
            ], 404);
        }

        $revisiTugasAkhir = RevisiTugasAkhir::where('tugas_akhir_id', $tugasAkhir->id)
            ->where('mhs_nim', $mahasiswa->mhs_nim) // Hanya revisi milik user yang login
            ->with(['tugasAkhir', 'dosen', 'mahasiswa'])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $revisiTugasAkhir
        ]);
    }

    /**
     * Upload file revisi untuk revisi tugas akhir terbaru milik user
     */
    public function uploadFileRevisi(Request $request)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'file_revisi' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240' // max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Deteksi tugas_akhir_id otomatis dari user yang login
        $tugasAkhir = DB::table('mahasiswa')
            ->join('tugas_akhir_anggota', 'mahasiswa.mhs_nim', '=', 'tugas_akhir_anggota.mhs_nim')
            ->join('tugas_akhir', 'tugas_akhir_anggota.tugas_akhir_id', '=', 'tugas_akhir.id')
            ->where('mahasiswa.user_id', $user->id)
            ->where('tugas_akhir.status', '!=', 'Selesai')  // Hanya tugas akhir yang aktif
            ->select('tugas_akhir.id')
            ->first();

        if (!$tugasAkhir) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki tugas akhir aktif'
            ], 404);
        }

        // Ambil revisi terbaru milik user ini untuk tugas akhir ini
        $revisiTugasAkhir = RevisiTugasAkhir::where('tugas_akhir_id', $tugasAkhir->id)
            ->where('mhs_nim', $mahasiswa->mhs_nim) // Hanya revisi milik user yang login
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$revisiTugasAkhir) {
            return response()->json([
                'status' => 'error',
                'message' => 'Belum ada revisi untuk tugas akhir ini. Silakan buat revisi terlebih dahulu.'
            ], 404);
        }

        // Hapus file lama jika ada
        if ($revisiTugasAkhir->file_revisi) {
            Storage::disk('public')->delete($revisiTugasAkhir->file_revisi);
        }

        // Upload file baru
        $file = $request->file('file_revisi');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('revisi_tugas_akhir', $fileName, 'public');

        // Update record revisi dengan path file baru
        $revisiTugasAkhir->update([
            'file_revisi' => $filePath
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'File revisi berhasil diupload',
            'data' => [
                'revisi_id' => $revisiTugasAkhir->id,
                'tugas_akhir_id' => $tugasAkhir->id,
                'file_path' => $filePath,
                'file_url' => asset('storage/' . $filePath),
                'updated_at' => $revisiTugasAkhir->updated_at
            ]
        ], 200);
    }

    /**
     * Upload file revisi untuk revisi tugas akhir tertentu (dengan ID spesifik)
     */
    public function uploadFileRevisiById(Request $request, $revisi_id)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'file_revisi' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240' // max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Ambil data revisi untuk cek akses dan file lama
        $revisiTugasAkhir = RevisiTugasAkhir::with('tugasAkhir')->findOrFail($revisi_id);

        // Cek apakah revisi milik user yang login
        if ($revisiTugasAkhir->mhs_nim != $mahasiswa->mhs_nim) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses ke revisi ini'
            ], 403);
        }

        // Hapus file lama jika ada
        if ($revisiTugasAkhir->file_revisi) {
            Storage::disk('public')->delete($revisiTugasAkhir->file_revisi);
        }

        // Upload file baru
        $file = $request->file('file_revisi');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('revisi_tugas_akhir', $fileName, 'public');

        // Update record revisi dengan path file baru
        $revisiTugasAkhir->update([
            'file_revisi' => $filePath
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'File revisi berhasil diupload',
            'data' => [
                'revisi_id' => $revisiTugasAkhir->id,
                'file_path' => $filePath,
                'file_url' => asset('storage/' . $filePath),
                'updated_at' => $revisiTugasAkhir->updated_at
            ]
        ], 200);
    }
}