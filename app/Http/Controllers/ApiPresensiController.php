<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiPresensiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|integer',
            'foto_absen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Simpan foto absensi ke storage
            $path = $request->file('foto_absen')->store('absensi', 'public');

            // Buat record absensi
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
            ], 200);
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