<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiPresensiController extends Controller
{
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'id_pegawai' => 'required|integer',
    //         'foto_absen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     try {
    //         // Simpan foto absensi ke storage
    //         $path = $request->file('foto_absen')->store('absensi', 'public');

    //         // Buat record absensi
    //         $absensi = AbsensiModel::create([
    //             'id_pegawai' => (int)$request->id_pegawai, // Pastikan casting ke integer
    //             'tanggal' => Carbon::now()->toDateString(),
    //             'waktu_masuk' => Carbon::now(),
    //             'status_absen' => 'Hadir',
    //             'lokasi_absen' => $request->lokasi_absen ?? 'Malang', // Lokasi default
    //             'foto_absen' => $path,
    //         ]);

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Absensi berhasil disimpan',
    //             'data' => $absensi,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal menyimpan absensi',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|integer',
            'foto_absen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Simpan foto absensi ke storage
            $path = $request->file('foto_absen')->store('absensi', 'public');

            // Ambil gambar yang baru saja di-upload
            $image = $request->file('foto_absen');

            // Inisialisasi client Guzzle
            $client = new Client();

            // Persiapkan data untuk dikirim
            $multipart = [
                [
                    'name' => 'file',
                    'contents' => fopen($image->getPathname(), 'r'),
                    'filename' => 'foto_absen.jpg'
                ]
            ];

            // Kirim gambar ke API FastAPI untuk dikenali wajahnya
            $response = $client->post('http://192.168.11.163:8000/recognize_face/', [
                'multipart' => $multipart
            ]);

            // Mendapatkan response dari FastAPI
            $responseData = json_decode($response->getBody()->getContents(), true);

            // Mengecek apakah wajah terdeteksi dan mengembalikan hasil
            if (isset($responseData['predicted_name'])) {
                $predictedName = $responseData['predicted_name'];
                $confidence = $responseData['confidence'];
            } elseif (isset($responseData['message']) && $responseData['message'] === 'No face detected in the image.') {
                // Tangani kondisi jika wajah tidak terdeteksi
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wajah tidak terdeteksi dalam gambar',
                ], 400);
            } else {
                $predictedName = null;
                $confidence = null;
            }

            // Menambahkan logika untuk memeriksa apakah predicted_name dan id_pegawai tidak sesuai
            if ($predictedName && (int)$predictedName === (int)$request->id_pegawai) {
                // Buat record absensi jika wajah sesuai dengan id_pegawai
                $absensi = AbsensiModel::create([
                    'id_pegawai' => (int)$request->id_pegawai, // Pastikan casting ke integer
                    'tanggal' => Carbon::now()->toDateString(),
                    'waktu_masuk' => Carbon::now(),
                    'status_absen' => 'Hadir',
                    'lokasi_absen' => $request->lokasi_absen ?? 'Malang', // Lokasi default
                    'foto_absen' => $path,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Absensi berhasil disimpan',
                    'data' => $absensi,
                    'face_recognition' => [
                        'predicted_name' => $predictedName,
                        'confidence' => $confidence
                    ]
                ], 200);
            } else {
                // Jika wajah tidak sesuai dengan id_pegawai
                return response()->json([
                    'status' => 'error',
                    'message' => 'Foto tidak sesuai, ID Pegawai tidak cocok dengan wajah yang terdeteksi',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan absensi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request)
    {
        $request->validate([
            'id_absensi' => 'required|integer',
        ]);

        try {
            // Cari data absensi berdasarkan id_absensi
            $absensi = AbsensiModel::find($request->id_absensi);

            if (!$absensi) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data absensi tidak ditemukan',
                ], 404);
            }

            // Update kolom waktu_keluar
            $absensi->waktu_keluar = Carbon::now();
            $absensi->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Waktu keluar berhasil diperbarui',
                'data' => $absensi,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui waktu keluar',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}