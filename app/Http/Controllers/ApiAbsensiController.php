<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use Database\Seeders\AbsensiSeeder;
use Illuminate\Http\Request;

class ApiAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absensis = AbsensiModel::all();
        return response()->json($absensis);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(AbsensiModel $absensi)
    {
        return response()->json($absensi);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AbsensiModel $absensi)
    {
        $absensi->delete();
        return response()->json(null, 204);
    }
}