<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PegawaiModel;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $level_id = $user->id_level;
        // $userPhoto = $this->getUserPhoto();
        
        if ($user->id_level == '1')
        {
            // HRD dapat melihat semua pegawai dan filter per SPV
            $pegawaiData = PegawaiModel::all();
            $totalPegawai = $pegawaiData->count();
            
            // Hitung jumlah pegawai per Supervisor (Level 2)
            $pegawaiPerSpv = PegawaiModel::where('id_level', 2)
                            ->withCount('bawahan')
                            ->get();

            return view('hrd.dashboard', [
                'level_id' => $level_id,
                'pegawaiData' => $pegawaiData,
                'pegawaiPerSpv' => $pegawaiPerSpv,
                'totalPegawai' => $totalPegawai,
            ]);
        }       
        elseif ($user->id_level == '2') 
        {
           // Supervisor hanya melihat pegawai di bawah supervisor-nya
           $pegawaiData = PegawaiModel::where('boss', $user->id_pegawai)->get();
           $totalPegawai = $pegawaiData->count();

           return view('spv.dashboard', [
               'level_id' => $level_id,
               'pegawaiData' => $pegawaiData,
               'totalPegawai' => $totalPegawai,
           ]);
        }
    }

    // public function getUserPhoto()
    // {
    //     $user = Auth::user();
    //     $id_pegawai = $user->id_pegawai;
    //     $foto = DB::table('m_pegawai')->where('id_pegawai', $id_pegawai)->value('foto');
    //     if ($foto) {
    //         // Ubah format base64 ke PNG
    //         $base64Foto = 'data:image/png;base64,' . base64_encode($foto);
    //         return $base64Foto;
    //     }
    //     return null;
    // }  
}