<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\PegawaiModel;
use App\Models\PenerimaModel;
use App\Models\PengajuanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $level = $user->id_level;
        $jabatan = PegawaiModel::select('jabatan')->get();
    
        // Ambil semua pegawai
        $pegawai = PegawaiModel::all(); // Ambil semua pegawai
    
        if ($level == 1) {
            $jabatanpgw = PegawaiModel::select('jabatan')->distinct()->get();
            return view('hrd.user-management', ['jabatanpgw' => $jabatanpgw, 'pegawai' => $pegawai]);    
        } elseif ($level == 2) {
            return view('spv.user-management', ['pegawai' => $pegawai]);    
        }
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        $userLevel = $user->id_level;
        $pegawai = PegawaiModel::with('level');
    
        return DataTables::of($pegawai)
        ->addIndexColumn()
        ->addColumn('aksi', function ($pegawai) {
            return '<div class="btn-group" role="group" aria-label="Actions">
                        <a href="' . url('/pegawai/' . $pegawai->id_pegawai) . '" class="btn btn-outline-primary" title="View">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                        <a href="' . url('/pegawai/' . $pegawai->id_pegawai . '/edit') . '" class="btn btn-outline-secondary" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="' . url('/pegawai/' . $pegawai->id_pegawai . '/ubah_status') . '" class="btn btn-outline-danger" title="Delete">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </a>
                    </div>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }
    
    public function create()
    {
        $level = LevelModel::all();

        $user = Auth::user();
        $rt = null;

        if ($user->id_level == 2) {
            $rt = $user->rt;
        }

        return view('hrd.pegawai.create', [
            'level' => $level,
            'rt' => $rt
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_level' => 'required|integer',
            'nama_pegawai' => 'required|string|max:100',
            'no_pegawai' => 'required|integer|unique:pegawai,no_pegawai',
            'boss' => 'nullable|integer',
            'jabatan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);
    
        // Proses unggah file
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Tentukan path penyimpanan secara manual
            $customPath = 'C:\Users\Dayutirta\OneDrive\Music\semester 5\mobile\web presensia\storage\foto'; // Path penyimpanan sesuai dengan yang Anda tentukan
    
            // Pastikan directory penyimpanan ada, jika tidak, buat directory
            if (!file_exists($customPath)) {
                mkdir($customPath, 0755, true);
            }
    
            // Pindahkan file ke path yang ditentukan
            $file->move($customPath, $filename);
    
            // Set path file untuk disimpan di database
            $filePath = '/storage/foto/' . $filename;

    
            // Cek apakah path tidak kosong
            if (!$filePath) {
                return redirect()->back()->withErrors(['foto' => 'File upload failed']);
            }
        } else {
            return redirect()->back()->withErrors(['foto' => 'File upload failed']);
        }
    
        PegawaiModel::create([
            'id_level' => $request->id_level,
            'nama_pegawai' => $request->nama_pegawai,
            'no_pegawai' => $request->no_pegawai,
            'boss' => $request->boss,
            'jabatan' => $request->jabatan,
            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'password' => bcrypt($request->password), 
            'foto' => $filePath,
        ]);
    
        return redirect('/pegawai')->with('success', 'Data berhasil ditambahkan');
    }
    
    public function show(String $id)
    {  
        $pegawai = PegawaiModel::with('level')->where('id_pegawai', $id)->first();
        $boss=$pegawai->boss;

        $spv = PegawaiModel::with('level')->where('boss', $boss)->get();
        return view('hrd.pegawai.detail', [
            'spv' => $spv,
            'pegawai' => $pegawai,
        ]);
    }

    public function edit(String $id)
    {
        $pegawai = PegawaiModel::where('id_pegawai', $id)->first();
        $level = LevelModel::all();
        return view('hrd.pegawai.edit', [
            'pegawai' => $pegawai,
            'level' => $level,
        ]);
    }

    public function update(Request $request, String $id)
    {
        $request->validate([
            'id_level' => 'required|integer',
            'nama_pegawai' => 'required|string|max:100',
            'no_pegawai' => 'required|integer|unique:pegawai,no_pegawai',
            'boss' => 'nullable|integer',
            'jabatan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);
    
        $pegawai = PegawaiModel::find($id);
    
        if (!$pegawai) {
            return redirect()->back()->withErrors(['message' => 'Data pegawai tidak ditemukan']);
        }
    
        // Handle file upload if new file is provided
        if ($request->hasFile('foto')) {
            // Validate and store the new file
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Specify storage path
            $customPath = 'C:\Users\Dayutirta\OneDrive\Music\semester 5\mobile\web presensia\storage\foto';
    
            // Ensure storage directory exists, if not, create it
            if (!file_exists($customPath)) {
                mkdir($customPath, 0755, true);
            }
    
            // Move file to specified path
            $file->move($customPath, $filename);
    
            // Set file path to be saved in the database
            $filePath = '/storage/foto/' . $filename;
    
            // Update pegawai data including the new photo path
            PegawaiModel::create([
                'id_level' => $request->id_level,
                'nama_pegawai' => $request->nama_pegawai,
                'no_pegawai' => $request->no_pegawai,
                'boss' => $request->boss,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'password' => bcrypt($request->password), 
                'foto' => $filePath,
            ]);
    
        } else {
            // Update pegawai data without changing the photo
            PegawaiModel::create([
                'id_level' => $request->id_level,
                'nama_pegawai' => $request->nama_pegawai,
                'no_pegawai' => $request->no_pegawai,
                'boss' => $request->boss,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'password' => bcrypt($request->password), 
            ]);
        }
    
        return redirect('/pegawai')->with('success', 'Data berhasil diubah');
    }
}
