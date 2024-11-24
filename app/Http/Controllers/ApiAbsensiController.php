<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use Illuminate\Http\Request;

class ApiAbsensiController extends Controller
{
    public function index()
    {
        $absensis = AbsensiModel::all();
        return response()->json($absensis);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'id_izin' => 'nullable|exists:perizinan,id_izin',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i:s',
            'waktu_keluar' => 'nullable|date_format:H:i:s',
            'status_absen' => 'required|string|max:50',
            'foto_absen' => 'nullable|file',
            'lokasi_absen' => 'required|string|max:100'
        ]);

        $absensi = AbsensiModel::create($validated);
        return response()->json($absensi, 201);
    }

    public function show(AbsensiModel $absensi)
    {
        return response()->json($absensi);
    }

    public function update(Request $request, AbsensiModel $absensi)
    {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'id_izin' => 'nullable|exists:perizinan,id_izin',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i:s',
            'waktu_keluar' => 'nullable|date_format:H:i:s',
            'status_absen' => 'required|string|max:50',
            'foto_absen' => 'nullable|file',
            'lokasi_absen' => 'required|string|max:100'
        ]);

        $absensi->update($validated);
        return response()->json($absensi);
    }

    public function destroy(AbsensiModel $absensi)
    {
        $absensi->delete();
        return response()->json(null, 204);
    }

    public function history(Request $request)
    {
        // Ambil parameter id_pegawai dari request
        $idPegawai = $request->input('id_pegawai');

        // Validasi apakah id_pegawai ada
        if (!$idPegawai) {
            return response()->json([
                'status' => 'error',
                'message' => 'id_pegawai tidak ditemukan dalam request'
            ], 400);
        }

        // Query data absensi berdasarkan id_pegawai
        $attendanceData = AbsensiModel::where('id_pegawai', $idPegawai)->get();

        // Periksa apakah ada data
        if ($attendanceData->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tidak ada data absensi yang ditemukan untuk id_pegawai ini'
            ], 200);
        }

        // Berikan respons data
        return response()->json([
            'status' => 'success',
            'data' => $attendanceData
        ], 200);
    }
}
