<?php

namespace App\Http\Controllers;
use App\Models\AbsensiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $level = $user->id_level;
        $absensi = AbsensiModel::all(); 
        if ($level == 1) {
            return view('hrd.absensi-management', [ 'absensi' => $absensi]);    
        } 
    }

    public function list(Request $request)
    {
        $limit = $request->input('length', 100); // Default 100
        $offset = $request->input('start', 0);
    
        // Mengambil data absensi dengan relasi pegawai
        $absensi = AbsensiModel::with('pegawai')
                    ->skip($offset)
                    ->take($limit)
                    ->get();
        $totalRecords = AbsensiModel::count();
        return DataTables::of($absensi)
            ->addIndexColumn()
            ->setTotalRecords($totalRecords)
            ->make(true);
    }
}