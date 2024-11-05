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
            'nama_pegawai' => 'required|string|max:100',
            'no_pegawai' => 'required|integer|unique:pegawai',
            'boss' => 'nullable|exists:pegawai,id_pegawai',
            'jabatan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $pegawai = PegawaiModel::create([
                'nama_pegawai' => $request->nama_pegawai,
                'no_pegawai' => $request->no_pegawai,
                'boss' => $request->boss,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'password' => Hash::make($request->password),
                'id_level' => 3
            ]);

            // Buat token secara manual
            $token = auth('api')->login($pegawai);

            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Could not create token',
                ], 500);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Pegawai registered successfully',
                'pegawai' => $pegawai,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => config('jwt.ttl') * 60 // Menggunakan config JWT langsung
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error during registration',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_pegawai' => 'required|integer',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $credentials = $request->only('no_pegawai', 'password');

            if (!$token = auth()->attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 401);
            }

            $pegawai = auth()->user();

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'pegawai' => $pegawai,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error during login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Method tambahan untuk logout (opsional)
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
