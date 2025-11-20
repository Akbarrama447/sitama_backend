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

Route::get('/mhsw-bimbingan', [BimbinganController::class, 'index'])
     ->name('mhsw-bimbingan');

Route::get('/bimbingan/verify/{id}', [BimbinganController::class, 'verify'])->name('bimbingan.verify');
Route::get('/bimbingan/reject/{id}', [BimbinganController::class, 'reject'])->name('bimbingan.reject');

Route::get('/sidang-ta', [SidangController::class, 'index'])
     ->name('sidang-ta');

Route::post('/sidang-ta/store', [SidangController::class, 'store'])->name('sidang.store');
