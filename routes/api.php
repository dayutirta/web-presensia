<?php

use App\Http\Controllers\ApiAbsensiController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiHomeController;
use App\Http\Controllers\ApiPresensiController;
use App\Http\Controllers\ApiProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [ApiAuthController::class, 'register']);
Route::post('registerImage', [ApiAuthController::class, 'registerImage']);
Route::post('login', [ApiAuthController::class, 'login']);
// Route::post('logout', [ApiAuthController::class, 'logout']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [ApiAuthController::class, 'logout']);
});

Route::post('/home/today', [ApiHomeController::class, 'getTodaysAttendance']);
Route::post('/home/user', [ApiHomeController::class, 'getUser']);
Route::post('/home/quota', [ApiHomeController::class, 'getRemainingQuota']);

Route::post('/presensi/store', [ApiPresensiController::class, 'store']);
Route::post('/presensi/update', [ApiPresensiController::class, 'update']);

Route::apiResource('absensi', ApiAbsensiController::class);

Route::get('/history', [ApiAbsensiController::class, 'history']);

Route::post('/password/update', [ApiProfileController::class, 'updatePassword']);