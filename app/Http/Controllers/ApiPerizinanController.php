<?php

namespace App\Http\Controllers;

use App\Models\PerizinanModel;
use Illuminate\Http\Request;

class ApiPerizinanController extends Controller
{
    /**
     * Display a listing of all perizinan requests.
     */
    public function index()
    {
        $perizinan = PerizinanModel::all();
        return response()->json($perizinan);
    }

    /**
     * Store a newly created perizinan request in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string|max:255',
            'status' => 'in:pending,diterima,ditolak' // Set default status to 'pending'
        ]);

        $validated['status'] = 'pending'; // Default status saat diajukan

        $perizinan = PerizinanModel::create($validated);
        return response()->json($perizinan, 201);
    }

    /**
     * Show the details of a specific perizinan request.
     */
    public function show(PerizinanModel $perizinan)
    {
        return response()->json($perizinan);
    }

    /**
     * Approve a perizinan request.
     */
    public function approve(PerizinanModel $perizinan)
    {
        $perizinan->status = 'diterima';
        $perizinan->save();

        return response()->json(['message' => 'Perizinan diterima', 'data' => $perizinan]);
    }

    /**
     * Reject a perizinan request.
     */
    public function reject(PerizinanModel $perizinan)
    {
        $perizinan->status = 'ditolak';
        $perizinan->save();

        return response()->json(['message' => 'Perizinan ditolak', 'data' => $perizinan]);
    }

    /**
     * Update a perizinan request (optional if admin needs to edit).
     */
    public function update(Request $request, PerizinanModel $perizinan)
    {
        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string|max:255',
            'status' => 'in:pending,diterima,ditolak'
        ]);

        $perizinan->update($validated);
        return response()->json($perizinan);
    }

    /**
     * Remove a specific perizinan request.
     */
    public function destroy(PerizinanModel $perizinan)
    {
        $perizinan->delete();
        return response()->json(null, 204);
    }
}
