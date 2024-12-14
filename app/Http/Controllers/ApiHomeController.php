<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsensiModel;
use App\Models\JatahPegawaiModel;
use App\Models\PegawaiModel;
use Carbon\Carbon;

class ApiHomeController extends Controller
{
    public function getTodaysAttendance(Request $request)
    {
        // Set timezone to Asia/Jakarta
        // date_default_timezone_set('Asia/Jakarta');
        // Carbon::setLocale('id');

        // Get the current date in Indonesian timezone
        $today = Carbon::now()->toDateString();

        // Get the id_pegawai from the request
        $idPegawai = $request->input('id_pegawai');

        // Query to get attendance data for today for the specified id_pegawai
        $attendanceData = AbsensiModel::where('tanggal', $today)
            ->where('id_pegawai', $idPegawai)
            ->get();

        // Check if data exists
        if ($attendanceData->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No attendance data found for today'
            ], 200);
        }

        // Return the data as JSON response
        return response()->json([
            'status' => 'success',
            'data' => $attendanceData
        ], 200);
    }

    public function getUser(Request $request)
    {
        // Get id_pegawai from request
        $idPegawai = $request->input('id_pegawai');

        // Fetch user data based on id_pegawai
        $user = PegawaiModel::where('id_pegawai', $idPegawai)->first();

        // Check if user exists
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found'
            ], 404);
        }

        // Return user data
        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function getRemainingQuota(Request $request)
    {
        // Ambil id_pegawai dari request
        $idPegawai = $request->input('id_pegawai');

        // Ambil tahun saat ini
        $currentYear = Carbon::now()->year;

        // Query untuk mendapatkan sisa WFA dan cuti menggunakan model
        $quotaData = JatahPegawaiModel::where('id_pegawai', $idPegawai)
            ->where('tahun', $currentYear)
            ->select('sisa_sakit', 'sisa_cuti')
            ->first();

        // Periksa apakah data ditemukan
        if (!$quotaData) {
            return response()->json([
                'status' => 'error',
                'message' => 'Quota data not found for the specified employee and year',
            ], 404);
        }

        // Return data sebagai JSON response
        return response()->json([
            'status' => 'success',
            'data' => [
                'sisa_sakit' => $quotaData->sisa_sakit,
                'sisa_cuti' => $quotaData->sisa_cuti,
            ],
        ], 200);
    }
}