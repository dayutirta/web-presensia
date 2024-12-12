<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\PegawaiModel;

class ApiProfileController extends Controller
{
    /**
     * Mengubah password pegawai
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_pegawai' => 'required',
            'password' => 'required|string|min:6',
            'password_baru' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Cari pegawai berdasarkan ID
            $pegawai = PegawaiModel::find($request->id_pegawai);

            if (!$pegawai) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pegawai tidak ditemukan',
                ], 404);
            }

            // Periksa apakah password lama cocok
            if (!Hash::check($request->password, $pegawai->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password lama tidak sesuai',
                ], 403);
            }

            // Update password dengan password baru
            $pegawai->password = Hash::make($request->password_baru);
            $pegawai->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diubah',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengubah password',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateFoto(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_pegawai' => 'required',  // Validasi id_pegawai
            'foto' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',  // Validasi foto (gambar)
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Cari pegawai berdasarkan ID
            $pegawai = PegawaiModel::find($request->id_pegawai);

            if (!$pegawai) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pegawai tidak ditemukan',
                ], 404);
            }

            // Periksa apakah file foto ada di request
            if ($request->hasFile('foto')) {
                // Ambil file gambar yang diunggah
                $foto = $request->file('foto');

                // Simpan gambar ke storage dan dapatkan nama file
                $fotoPath = $foto->store('public/foto_profil'); // Simpan di folder foto_profil

                // Ambil nama file dari path yang disimpan
                $fotoName = basename($fotoPath);

                // Update kolom foto di database
                $pegawai->foto = $fotoName;
                $pegawai->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Foto berhasil diubah',
                'data' => [
                    'foto' => $fotoName
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}