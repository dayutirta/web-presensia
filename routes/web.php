<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PerizinanController;
use App\Http\Controllers\AbsensiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing-page.index');
});
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk halaman form "Lupa Password" tapi gajadi dibuild
Route::get('login/forgot-password', function () {
    return view('session.reset-password.resetPassword');
})->name('forgot-password');
Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.reset');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::get('/hrd/dashboard', [UserController::class, 'index'])->name('hrd.dashboard');
    });
});

Route::group(['prefix' => 'pegawai'], function () {
    Route::get('/', [PegawaiController::class, 'index']);
    Route::post('/list', [PegawaiController::class, 'list']);
    Route::get('/create', [PegawaiController::class, 'create']);
    Route::post('/', [PegawaiController::class, 'store']);
    Route::get('/{id}', [PegawaiController::class, 'show']);
    Route::get('/{id}/edit', [PegawaiController::class, 'edit']);
    Route::put('/{id}', [PegawaiController::class, 'update']);
    Route::get('/{id}/hapus', [PegawaiController::class, 'hapus']);
});

Route::group(['prefix' => 'perizinan'], function () {
    Route::get('/', [PerizinanController::class, 'index'])->name('perizinan.index');
    Route::post('/list', [PerizinanController::class, 'list']);
    Route::get('/{id}', [PerizinanController::class, 'show']);
    Route::post('/{id}/accept', [PerizinanController::class, 'accept']);
    Route::post('/{id}/reject', [PerizinanController::class, 'reject']);
    Route::delete('/{id}', [PerizinanController::class, 'destroy']);
});

Route::group(['prefix' => 'absensi'], function () {
    Route::get('/', [AbsensiController::class, 'index']);
    Route::post('/list', [AbsensiController::class, 'list']);
});