<?php

namespace App\Http\Controllers;
use App\Models\LevelModel;
use App\Models\PegawaiModel;
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
                        <a href="' . url('/pegawai/' . $pegawai->id_pegawai . '/edit') . '" class="btn btn-outline-primary" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="' . url('/pegawai/' . $pegawai->id_pegawai . '/hapus') . '" class="btn btn-outline-danger" title="Delete">
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
            'id_level' => 'required|string|exists:level,id_level', // Pastikan id_level ada di tabel levels
            'nama_pegawai' => 'required|string|max:100',
            'no_pegawai' => 'required|string|unique:pegawai,no_pegawai',
            'boss' => 'nullable|string',
            'jabatan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'password' => 'required|string|min:3', 
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);
    
        try {
            // Proses upload foto jika ada
            $filePath = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Menyimpan foto ke public disk dan mendapatkan path relatif
                $filePath = $file->storeAs('foto', $filename, 'public');
            }
    
            // Simpan data pegawai ke database
            PegawaiModel::create([
                'id_level' => $request->id_level,
                'nama_pegawai' => $request->nama_pegawai,
                'no_pegawai' => $request->no_pegawai,
                'boss' => $request->boss,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'password' => bcrypt($request->password), // Password di-hash
                'foto' => $filePath,
            ]);
    
            // Redirect ke halaman pegawai dengan pesan sukses
            return redirect('/pegawai')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            // Jika ada kesalahan, tampilkan pesan error dan tetap di halaman yang sama
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data']);
        }
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
            'id_level' => 'required|string',
            'nama_pegawai' => 'required|string|max:100',
            'no_pegawai' => 'required|string',
            'jabatan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'password' => 'nullable|string|min:3', 
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
            $customPath = 'storage/foto';
    
            // Ensure storage directory exists, if not, create it
            if (!file_exists(public_path($customPath))) {
                mkdir(public_path($customPath), 0755, true);
            }
    
            // Move file to specified path
            $file->move(public_path($customPath), $filename);
    
            // Set file path to be saved in the database
            $filePath = $customPath . '/' . $filename;
    
            // Update pegawai data including the new photo path
            $pegawai->update([
                'id_level' => $request->id_level,
                'nama_pegawai' => $request->nama_pegawai,
                'no_pegawai' => $request->no_pegawai,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'password' => $request->password ? bcrypt($request->password) : $pegawai->password,
                'foto' => $filePath,
            ]);
        } else {
            // Update pegawai data without changing the photo
            $pegawai->update([
                'id_level' => $request->id_level,
                'nama_pegawai' => $request->nama_pegawai,
                'no_pegawai' => $request->no_pegawai,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'password' => $request->password ? bcrypt($request->password) : $pegawai->password,
            ]);
        }
    
        return redirect('/pegawai')->with('success', 'Data berhasil diubah');
    }
    public function hapus(String $id)
    {
        $pegawai = PegawaiModel::find($id);
        if (!$pegawai) {
            return redirect('/pegawai')->withErrors(['message' => 'Data pegawai tidak ditemukan']);
        }
        // Hapus file foto jika ada
        if ($pegawai->foto && file_exists(public_path($pegawai->foto))) {
            unlink(public_path($pegawai->foto));
        }
        $pegawai->delete();
        return redirect('/pegawai')->with('success', 'Data pegawai berhasil dihapus');
    }
}