<?php

namespace App\Http\Controllers;

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
        if ($request->jenis_izin === 'sakit' && !$request->hasFile('dokumen')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dokumen harus diisi jika jenis izin adalah sakit.',
            ], 400);
        }
        try {
            $dokumenPath = null;
            if ($request->hasFile('dokumen')) {
                $dokumenPath = $request->file('dokumen')->store('dokumen', 'public');
            }
            $izin = PerizinanModel::create([
                'id_pegawai' => (int)$request->id_pegawai,
                'jenis_izin' => $request->jenis_izin,
                'keterangan' => $request->keterangan,
                'dokumen' => $dokumenPath,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'status_izin' => 'pending',
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Izin berhasil disimpan',
                'data' => $izin,
            ], 200);
        } catch (\Exception $e) {
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