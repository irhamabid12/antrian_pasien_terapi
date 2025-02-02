<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
            if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin'){
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


    public function changePassword(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ], [
            'old_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru harus minimal :min karakter.',
            'confirm_password.required' => 'Konfirmasi password wajib diisi.',
            'confirm_password.same' => 'Konfirmasi password harus sama dengan password baru.',
        ], [
            'old_password' => 'Password Lama',
            'new_password' => 'Password Baru',
            'confirm_password' => 'Konfirmasi Password',
        ]);

        // Jika validasi gagal, kirim pesan error
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->old_password == $request->new_password) {
            return response()->json(['error' => 'Password baru tidak boleh sama dengan password lama.'], 422);
        }

        $user = Auth::user(); // Dapatkan user yang sedang login

        // Verifikasi password lama
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'Password lama tidak sesuai.'], 422);
        }

        // Update password baru
        $user->password = Hash::make($request->new_password);
        $user->updated_at = Carbon::now();
        $user->save();

        return response()->json([
            'message' => 'Password berhasil diperbarui.'
        ]);
    }
}
