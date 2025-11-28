<?php

use App\Http\Controllers\DBBackupController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SidangController;
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

Route::resource('manage-user', UserController::class);
Route::resource('manage-role', RoleController::class);
Route::resource('manage-menu', MenuController::class);
Route::resource('manage-permission', PermissionController::class)->only('store', 'destroy');


Route::get('dbbackup', [DBBackupController::class, 'DBDataBackup']);

Route::get('sidang-ta', [App\Http\Controllers\SidangController::class, 'index'])->name('sidang.index');
Route::get('sidang-ta/{ta_id}/role', [App\Http\Controllers\SidangController::class, 'determineRole'])->name('sidang.role');

Route::get('bimbingan', [App\Http\Controllers\BimbinganController::class, 'index'])->name('bimbingan.index');
Route::get('bimbingan/{ta}', [App\Http\Controllers\BimbinganController::class, 'show'])->name('bimbingan.show');
Route::post('bimbingan/{id}/verify', [App\Http\Controllers\BimbinganController::class, 'verify'])->name('bimbingan.verify');
Route::post('bimbingan/{id}/reject', [App\Http\Controllers\BimbinganController::class, 'reject'])->name('bimbingan.reject');


Route::post('/sidang-ta/store', [SidangController::class, 'store'])->name('sidang.store');

// Nilai routes
Route::get('nilai/{ta_id}', [App\Http\Controllers\NilaiController::class, 'show'])->name('nilai.show');
Route::post('nilai/pembimbing/{ta_id}/{sidang_id}', [App\Http\Controllers\NilaiController::class, 'storePembimbing'])->name('nilai.pembimbing.store');
Route::post('nilai/penguji/{ta_id}/{sidang_id}', [App\Http\Controllers\NilaiController::class, 'storePenguji'])->name('nilai.penguji.store');
