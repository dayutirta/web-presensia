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

Route::get('/', function () {return redirect()->route('login');}); 
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk halaman form "Lupa Password"
Route::get('login/forgot-password', function () {
    return view('session.reset-password.resetPassword'); // Sesuaikan dengan nama view Anda
})->name('forgot-password');
Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.reset');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login:1']], function () {
		Route::get('/hrd/dashboard', [UserController::class, 'index'])->name('hrd.dashboard');
    });
    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::get('/spv/dashboard', [UserController::class, 'index'])->name('spv.dashboard');
    });
});

Route::group(['prefix' => 'pegawai'], function() {
    Route::get('/', [PegawaiController::class, 'index']);          
    Route::post('/list', [PegawaiController::class, 'list']);
    Route::get('/create', [PegawaiController::class, 'create']);   
    Route::post('/', [PegawaiController::class, 'store']);         
    Route::get('/{id}', [PegawaiController::class, 'show']);
    Route::get('/{id}/edit', [PegawaiController::class, 'edit']);  
    Route::put('/{id}', [PegawaiController::class, 'update']);         
});

Route::group(['prefix' => 'perizinan'], function() {
    Route::get('/', [PerizinanController::class, 'index']);          
    Route::post('/list', [PerizinanController::class, 'list']);
    Route::get('/accept/{id}', [PerizinanController::class, 'accept']);
    Route::get('/reject/{id}', [PerizinanController::class, 'reject']);        
});

Route::group(['prefix' => 'absensi'], function() {
    Route::get('/', [AbsensiController::class, 'index']);          
    Route::post('/list', [AbsensiController::class, 'list']);
    Route::get('/{id}', [AbsensiController::class, 'show']);
    Route::get('/{id}/edit', [AbsensiController::class, 'edit']);  
    Route::put('/{id}', [AbsensiController::class, 'update']);         
});