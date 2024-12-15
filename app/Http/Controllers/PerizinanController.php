<?php

namespace App\Http\Controllers;
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
        } 
    }
    public function list(Request $request)
    {
        $user = Auth::user();
        $userLevel = $user->id_level;
        $perizinan = PerizinanModel::with('pegawai')->get();
    
        return DataTables::of($perizinan)
            ->addIndexColumn()
            ->addColumn('dokumen', function ($perizinan) {
                if ($perizinan->dokumen) {
                    $fileUrl = url('storage/dokumen/' . $perizinan->dokumen); // Path to the file
                    return '<a href="' . $fileUrl . '" target="_blank" class="btn btn-outline-info btn-sm">Download Dokumen</a>';
                } else {
                    return '<span class="text-muted">Tidak Ada Dokumen</span>';
                }
            })
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
            })
            ->addColumn('ubah_status', function($perizinan) {
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
            ->rawColumns(['dokumen', 'aksi', 'ubah_status'])
            ->make(true);
    }
    public function accept($id)
    {
        $perizinan = PerizinanModel::findOrFail($id);
        $perizinan->status_izin = 'Disetujui';
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
    public function show($id)
    {
        // Pastikan data diambil beserta relasi pegawai
        $perizinan = PerizinanModel::with('pegawai')->find($id);

        if (!$perizinan) {
            return redirect('/perizinan')->with('error', 'Data perizinan tidak ditemukan.');
        }

        return view('perizinan.show', ['perizinan' => $perizinan]);
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