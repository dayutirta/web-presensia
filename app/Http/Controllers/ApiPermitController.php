<?php

namespace App\Http\Controllers;

use App\Models\JatahPegawaiModel;
use App\Models\PerizinanModel;
use Illuminate\Http\Request;

class ApiPermitController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|integer',
            'jenis_izin' => 'required|string',
            'keterangan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'dokumen' => 'nullable|file|mimes:pdf,jpeg,png,jpg,docx'
        ]);

        // Memastikan bahwa dokumen harus ada jika jenis izin adalah sakit
        if ($request->jenis_izin === 'sakit' && !$request->hasFile('dokumen')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dokumen harus diisi jika jenis izin adalah sakit.',
            ], 400);
        }

        try {
            // Cek sisa izin berdasarkan jenis izin
            $pegawai = JatahPegawaiModel::where('id_pegawai', $request->id_pegawai)->first();

            if (!$pegawai) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pegawai tidak ditemukan.',
                ], 404);
            }

            // Pengecekan sisa izin berdasarkan jenis izin
            if ($request->jenis_izin === 'Sakit' && $pegawai->sisa_sakit <= 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jatah sakit pegawai habis.',
                ], 400);
            }

            if ($request->jenis_izin === 'Cuti' && $pegawai->sisa_cuti <= 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jatah cuti pegawai habis.',
                ], 400);
            }

            // Jika dokumen diunggah, simpan di storage dan ambil path-nya
            $dokumenPath = null;
            if ($request->hasFile('dokumen')) {
                $dokumenPath = $request->file('dokumen')->store('dokumen', 'public'); // Menyimpan dokumen ke storage/public/dokumen
            }

            // Menyimpan data izin ke database
            $izin = PerizinanModel::create([
                'id_pegawai' => (int)$request->id_pegawai,
                'jenis_izin' => $request->jenis_izin,
                'keterangan' => $request->keterangan,
                'dokumen' => $dokumenPath, // Menyimpan path dokumen relatif
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'status_izin' => 'pending',
            ]);

            // Menampilkan respons sukses
            return response()->json([
                'status' => 'success',
                'message' => 'Izin berhasil disimpan',
                'data' => $izin,
            ], 200);
        } catch (\Exception $e) {
            // Menampilkan respons error jika terjadi kesalahan
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan izin',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'id_pegawai' => 'required|integer',
    //         'jenis_izin' => 'required|string|in:wfh,sakit,cuti',
    //         'keterangan' => 'required|string',
    //         'tanggal_mulai' => 'required|date',
    //         'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
    //     ]);
    //     try {
    //         $izin = PerizinanModel::create([
    //             'id_pegawai' => (int)$request->id_pegawai,
    //             'jenis_izin' => $request->jenis_izin,
    //             'keterangan' => $request->keterangan,
    //             'dokumen' => null, // Set as null for database
    //             'tanggal_mulai' => $request->tanggal_mulai,
    //             'tanggal_akhir' => $request->tanggal_akhir,
    //             'status_izin' => 'pending',
    //         ]);
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Izin berhasil disimpan',
    //             'data' => $izin,
    //         ], 201);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal menyimpan izin',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    public function history(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|integer|exists:pegawai,id_pegawai',
        ]);
        $izin = PerizinanModel::where('id_pegawai', $request->id_pegawai)
            ->select('jenis_izin', 'tanggal_mulai', 'tanggal_akhir', 'status_izin', 'keterangan')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($izin->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tidak ada data izin untuk id_pegawai ini',
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'data' => $izin,
        ], 200);
    }
}