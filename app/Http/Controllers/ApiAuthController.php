<?php

namespace App\Http\Controllers;

use App\Models\PegawaiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_pegawai' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            // Cari pegawai berdasarkan no_pegawai
            $pegawai = PegawaiModel::where('no_pegawai', $request->no_pegawai)->first();

            if (!$pegawai) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Nomor pegawai tidak terdaftar, register gagal',
                ], 404);
            }

            // Update data pegawai
            $pegawai->update([
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pegawai updated successfully',
                'pegawai' => $pegawai,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error during update',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_pegawai' => 'required|integer',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $credentials = $request->only('no_pegawai', 'password');

            // Pastikan auth()->attempt menghasilkan token string
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Nomor pegawai atau password salah',
                ], 404);
            }

            // Ambil data pengguna yang berhasil login
            $pegawai = auth('api')->user();

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'pegawai' => $pegawai,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => config('jwt.ttl') * 60
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat login',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}