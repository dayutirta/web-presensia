<?php

namespace App\Http\Controllers;

use App\Models\PegawaiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{

    // public function registerImage(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'id_pegawai' => 'required',
    //         'files' => 'required|array',  // Pastikan ada tepat 5 file
    //         // 'files.*' => 'mimes:jpg',  // Validasi setiap file (maksimal 10MB)
    //     ]);

    //     try {
    //         // Ambil ID Pegawai
    //         $idPegawai = $request->input('id_pegawai');

    //         // Loop melalui setiap file dan simpan
    //         $paths = [];
    //         foreach ($request->file('files') as $file) {
    //             $path = $file->store('absensi/' . $idPegawai, 'public');  // Simpan file dalam folder berdasarkan id_pegawai
    //             $paths[] = $path;  // Simpan path file ke dalam array
    //         }

    //         // Response sukses
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Files uploaded successfully',
    //             'data' => [
    //                 'id_pegawai' => $idPegawai,
    //                 'file_paths' => $paths,
    //             ],
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Response error
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Failed to upload files',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function registerImage(Request $request)
    {
        // Validasi input, misalnya memastikan ada id_pegawai dan file yang diupload
        $request->validate([
            'id_pegawai' => 'required|string',
            'files' => 'required|array',  // Pastikan ada tepat 5 file
        ]);

        // Ambil id_pegawai dan files dari request
        $id_pegawai = $request->input('id_pegawai');
        $files = $request->file('files');

        // Inisialisasi client Guzzle
        $client = new Client();

        // Persiapkan data untuk dikirim ke FastAPI
        $multipart = [];
        foreach ($files as $key => $file) {
            $multipart[] = [
                'name'     => 'files',  // Nama parameter yang diterima oleh FastAPI
                'contents' => fopen($file->getPathname(), 'r'),
                'filename' => $file->getClientOriginalName(),
            ];
        }

        // Menambahkan query string untuk id_pegawai
        $query = [
            'id_pegawai' => $id_pegawai,
        ];

        try {
            // Kirim permintaan POST ke FastAPI
            $response = $client->post('http://192.168.11.163:8000/add_pegawai/', [
                'multipart' => $multipart,
                'query' => $query
            ]);

            // Mendapatkan hasil response dari FastAPI
            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Mengembalikan response dari FastAPI ke frontend (atau sesuai kebutuhan)
            return response()->json([
                'message' => $responseBody['message'] ?? 'Unknown response',
                'data' => $responseBody,
            ]);
        } catch (\Exception $e) {
            // Tangani error jika API FastAPI gagal dijangkau atau ada masalah lain
            return response()->json([
                'error' => 'Failed to communicate with FastAPI',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

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



    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'no_pegawai' => 'required|string|max:20',
    //         'alamat' => 'required|string|max:255',
    //         'nohp' => 'required|string|max:20',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     try {
    //         // Find pegawai by no_pegawai
    //         $pegawai = PegawaiModel::where('no_pegawai', $request->no_pegawai)->first();

    //         if (!$pegawai) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Nomor pegawai tidak terdaftar, register gagal',
    //             ], 404);
    //         }

    //         // Update pegawai data
    //         $pegawai->update([
    //             'alamat' => $request->alamat,
    //             'nohp' => $request->nohp,
    //             'password' => Hash::make($request->password),
    //         ]);

    //         // Generate token
    //         $token = auth('api')->login($pegawai);

    //         if (!$token) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Could not create token',
    //             ], 500);
    //         }

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Pegawai updated successfully',
    //             'pegawai' => $pegawai,
    //             'authorization' => [
    //                 'token' => $token,
    //                 'type' => 'bearer',
    //                 'expires_in' => config('jwt.ttl') * 60
    //             ]
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Error during update',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'no_pegawai' => 'required|string|max:20',
    //         'alamat' => 'required|string|max:255',
    //         'nohp' => 'required|string|max:20',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     // Check if the employee already exists
    //     $pegawai = PegawaiModel::where('no_pegawai', $request->no_pegawai)->first();

    //     if ($pegawai) {
    //         // Update existing employee
    //         $pegawai->update([
    //             'alamat' => $request->alamat,
    //             'nohp' => $request->nohp,
    //             'password' => Hash::make($request->password),
    //         ]);
    //         $message = 'Pegawai updated successfully';

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => $message,
    //             'pegawai' => $pegawai
    //         ], 200);
    //     } else {
    //         $message = 'Nomor pegawai tidak terdaftar, register gagal';
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $message,
    //         ], 404);
    //     }
    // }

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

    public function logout(Request $request)
    {
        try {
            // Logout dengan menghapus token pengguna saat ini
            auth('api')->logout();

            return response()->json([
                'status' => 'success',
                'message' => 'Logout berhasil',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat logout',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    // // Method tambahan untuk logout (opsional)
    // public function logout()
    // {
    //     auth()->logout();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Successfully logged out',
    //     ]);
    // }
}