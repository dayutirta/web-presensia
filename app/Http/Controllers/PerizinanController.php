<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\PerizinanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PerizinanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $level = $user->id_level;
        $perizinan = PerizinanModel::all(); 
        if ($level == 1) {
            return view('hrd.permit-management', [ 'perizinan' => $perizinan]);    
        } elseif ($level == 2) {
            return view('spv.permit-management', ['perizinan' => $perizinan]);    
        }
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        $userLevel = $user->id_level;
        $perizinan = PerizinanModel::with('pegawai');
    
        return DataTables::of($perizinan)
        ->addIndexColumn()
        ->addColumn('aksi', function ($perizinan) {
            return '<div class="btn-group" role="group" aria-label="Actions">
                        <a href="' . url('/perizinan/' . $perizinan->id_perizinan) . '" class="btn btn-outline-primary" title="View">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                        <a href="' . url('/perizinan/' . $perizinan->id_perizinan . '/edit') . '" class="btn btn-outline-secondary" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="' . url('/perizinan/' . $perizinan->id_perizinan . '/destroy') . '" class="btn btn-outline-danger" title="Delete">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </a>
                    </div>';

            return $buttons;
        })
        ->addColumn('ubah_status', function($perizinan) {
            // Cek status dan tampilkan tombol Terima/Tolak
            $buttons = '';
            if ($perizinan->status_izin == 'Pending') {
                $buttons .= '<form action="/perizinan/' . $perizinan->id_izin . '/accept" method="POST" style="display: inline;">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-outline-success btn-sm">Terima</button>
                            </form>';
                $buttons .= '<form action="/perizinan/' . $perizinan->id_izin . '/reject" method="POST" style="display: inline;">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-outline-danger btn-sm">Tolak</button>
                            </form>';
            } else {
                $buttons .= '<span class="badge bg-secondary">' . $perizinan->status_izin . '</span>';
            }
            return $buttons;
        })
        ->rawColumns(['ubah_status'], ['aksi'])
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

        return view('hrd.perizinan.create', [
            'level' => $level,
            'rt' => $rt
        ]);
    }

    public function accept($id)
    {
        $perizinan = PerizinanModel::findOrFail($id);
        $perizinan->status_izin = 'Diterima';
        $perizinan->save();

        return redirect()->route('perizinan.index')->with('success', 'Perizinan diterima');
    }

    public function reject($id)
    {
        $perizinan = PerizinanModel::findOrFail($id);
        $perizinan->status_izin = 'Ditolak';
        $perizinan->save();

        return redirect()->route('perizinan.index')->with('error', 'Perizinan ditolak');
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_level' => 'required|integer',
            'nama_perizinan' => 'required|string|max:100',
            'no_perizinan' => 'required|integer|unique:perizinan,no_perizinan',
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
    
        PerizinanModel::create([
            'id_level' => $request->id_level,
            'nama_perizinan' => $request->nama_perizinan,
            'no_perizinan' => $request->no_perizinan,
            'boss' => $request->boss,
            'jabatan' => $request->jabatan,
            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'password' => bcrypt($request->password), 
            'foto' => $filePath,
        ]);
    
        return redirect('/perizinan')->with('success', 'Data berhasil ditambahkan');
    }
    
    // public function show(String $id)
    // {  
    //     $perizinan = PerizinanModel::with('level')->where('id_izin', $id)->first();
    //     $boss=$perizinan->boss;

    //     $spv = PerizinanModel::with('level')->where('boss', $boss)->get();
    //     return view('hrd.perizinan.detail', [
    //         'spv' => $spv,
    //         'perizinan' => $perizinan,
    //     ]);
    // }

    public function show($id)
    {
        // Pastikan data diambil beserta relasi pegawai
        $perizinan = PerizinanModel::with('pegawai')->find($id);

        if (!$perizinan) {
            return redirect('/perizinan')->with('error', 'Data perizinan tidak ditemukan.');
        }

        return view('perizinan.show', ['perizinan' => $perizinan]);
    }

    public function edit(String $id)
    {
        $perizinan = PerizinanModel::where('id_perizinan', $id)->first();
        $level = LevelModel::all();
        return view('hrd.perizinan.edit', [
            'perizinan' => $perizinan,
            'level' => $level,
        ]);
    }

    public function update(Request $request, String $id)
    {
        $request->validate([
            'id_level' => 'required|integer',
            'nama_perizinan' => 'required|string|max:100',
            'no_perizinan' => 'required|integer|unique:perizinan,no_perizinan',
            'boss' => 'nullable|integer',
            'jabatan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);
    
        $perizinan = PerizinanModel::find($id);
    
        if (!$perizinan) {
            return redirect()->back()->withErrors(['message' => 'Data perizinan tidak ditemukan']);
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
    
            // Update perizinan data including the new photo path
            PerizinanModel::create([
                'id_level' => $request->id_level,
                'nama_perizinan' => $request->nama_perizinan,
                'no_perizinan' => $request->no_perizinan,
                'boss' => $request->boss,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'password' => bcrypt($request->password), 
                'foto' => $filePath,
            ]);
    
        } else {
            // Update perizinan data without changing the photo
            PerizinanModel::create([
                'id_level' => $request->id_level,
                'nama_perizinan' => $request->nama_perizinan,
                'no_perizinan' => $request->no_perizinan,
                'boss' => $request->boss,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'password' => bcrypt($request->password), 
            ]);
        }
    
        return redirect('/perizinan')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $perizinan = PerizinanModel::find($id);

        if (!$perizinan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $perizinan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

}
