<?php

namespace App\Http\Controllers;

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

        if (Auth::Attempt($data)) {
            if(auth()->user()->role == 'admin'){
                return redirect(url('admin/beranda/index'));
            } else {
                return redirect(url('pasien/pendaftaran/index'));
            }
        }else{
            Session::flash('error', 'Email atau Password Salah');
            return redirect(url('login'));
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
