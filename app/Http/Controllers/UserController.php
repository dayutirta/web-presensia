<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PegawaiModel;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $level_id = $user->id_level;
        
        // Tentukan rentang waktu default (harian)
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
    
        // Tentukan nama rentang waktu untuk label
        $rangeLabel = 'Harian'; // Default: Harian
    
        if ($request->has('range')) {
            switch ($request->range) {
                case 'weekly':
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                    $rangeLabel = 'Mingguan';
                    break;
                case 'monthly':
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                    $rangeLabel = 'Bulanan';
                    break;
            }
        }
    
        // Ambil data absensi berdasarkan rentang waktu
        $absensi = DB::table('absensi')
            ->select(DB::raw('
                SUM(CASE WHEN status_absen = \'Hadir\' THEN 1 ELSE 0 END) as hadir, 
                SUM(CASE WHEN status_absen = \'Izin\' THEN 1 ELSE 0 END) as izin, 
                SUM(CASE WHEN status_absen = \'Sakit\' THEN 1 ELSE 0 END) as sakit
            '))
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
    
        // Membuat array untuk label sumbu X
        $absensiLabels = [$rangeLabel];

        // Persentase status izin (Disetujui, Ditolak, Pending)
        $izinStatus = DB::table('perizinan')
            ->select(DB::raw('status_izin, COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status_izin')
            ->get();

        // Ambil total pegawai
        $totalPegawai = PegawaiModel::count();

        // Ambil total pegawai hadir hari ini
        $pegawaiHadirHariIni = DB::table('absensi')
            ->where('status_absen', 'Hadir')
            ->whereDate('tanggal', Carbon::today())
            ->count();

        // Ambil total perizinan yang pending
        $perizinanPending = DB::table('perizinan')
            ->where('status_izin', 'Pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        return view('hrd.dashboard', [
            'level_id' => $level_id,
            'absensi' => $absensi,
            'absensiLabels' => $absensiLabels,
            'izinStatus' => $izinStatus,
            'totalPegawai' => $totalPegawai,
            'pegawaiHadirHariIni' => $pegawaiHadirHariIni,
            'perizinanPending' => $perizinanPending,
        ]);
    }
}