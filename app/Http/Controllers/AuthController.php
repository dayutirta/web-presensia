<?php
namespace App\Http\Controllers;

use App\Models\PegawaiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index() {
        $user = Auth::user();
        if ($user) {
            if ($user->id_level == '1') {
                return redirect()->intended('hrd/dashboard');
            } 
        }
        return view('session.login-session');
    }

    public function proses_login(Request $request)
    {
        $request->validate([
            'no_pegawai' => 'required',
            'password' => 'required'
        ]);

        $no_pegawai = $request->input('no_pegawai');
        $password = $request->input('password');

        // Cek apakah pengguna ada di database dan verifikasi password
        $user = PegawaiModel::where('no_pegawai', $no_pegawai)->first();

        if ($user && Hash::check($password, $user->password)) {
            // Login pengguna secara manual
            Auth::login($user);

            // Redirect berdasarkan id_level
            if ($user->id_level == '1') {
                return redirect()->intended('hrd/dashboard');
            } 
        }

        return redirect('login')
            ->withInput()
            ->withErrors(['login_error' => 'no_pegawai atau password salah']);
    }

    public function logout(Request $request) {
        $request->session()->flush();
        Auth::logout();
        return redirect('login');
    }
}
