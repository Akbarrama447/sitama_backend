<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DBBackupController;
use App\Models\User;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SidangController; // Pastikan ini di-use
use App\Http\Controllers\UserController;
use App\Http\Controllers\BimbinganController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::permanentRedirect('/', '/login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('profil', ProfilController::class)->except('destroy');


// Route for config management - to be implemented later
// Route::group(['middleware' => ['role:admin']], function () {
//     Route::get('/configs', [ConfigController::class, 'index']);
// });

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/configs', [\App\Http\Controllers\ConfigController::class, 'index']);
});


Route::resource('manage-user', UserController::class);
Route::resource('manage-role', RoleController::class);
Route::resource('manage-menu', MenuController::class);
Route::resource('manage-permission', PermissionController::class)->only('store', 'destroy');

Route::get('dbbackup', [DBBackupController::class, 'DBDataBackup']);

// --- SIDANG ROUTES ---
Route::get('sidang-ta', [SidangController::class, 'index'])->name('sidang.index');

// --- BIMBINGAN ROUTES ---
Route::get('bimbingan', [BimbinganController::class, 'index'])->name('bimbingan.index');
Route::get('bimbingan/{ta}/mahasiswa/{mhs}', [BimbinganController::class, 'show'])->name('bimbingan.show');
Route::post('bimbingan/{id}/verify', [BimbinganController::class, 'verify'])->name('bimbingan.verify');
Route::post('bimbingan/{id}/reject', [BimbinganController::class, 'reject'])->name('bimbingan.reject');

// --- NILAI ROUTES (FIX: DIARAHKAN KE SidangController) ---
// Sebelumnya salah arah ke NilaiController yang logikanya belum update.
// Sekarang semua logika penilaian dipusatkan di SidangController.

Route::get('nilai/{ta_id}', [SidangController::class, 'show'])->name('nilai.show');

// --- UPDATE BAGIAN INI DI web.php ---

// Hapus parameter {ta_id} karena kita cuma butuh sidang_id untuk menyimpan nilai
// Ganti nama route (->name) agar sesuai dengan yang dipanggil di Blade

Route::post('nilai/pembimbing/{sidang_id}', [SidangController::class, 'storePembimbing'])
    ->name('sidang.storePembimbing');

Route::post('nilai/penguji/{sidang_id}', [SidangController::class, 'storePenguji'])
    ->name('sidang.storePenguji');

// Kalau yang sekretaris mau disesuaikan juga (opsional):
Route::post('nilai/sekretaris/{sidang_id}', [SidangController::class, 'storeSekretaris'])
    ->name('sidang.storeSekretaris');