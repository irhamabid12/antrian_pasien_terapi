<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrasiController extends Controller
{
    public function index() {
        return view('akun.register');
    }

    public function insert(Request $request) {
        // dd($request->all());

         // Validasi input
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'role' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Nama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'confirm_password.required' => 'Konfirmasi password baru wajib diisi.',
            'role.required' => 'Role baru wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan gunakan username lain.',
            'password.min' => 'Password baru harus minimal :min karakter.',
            'confirm_password.same' => 'Konfirmasi password harus sama dengan password.',
        ], [
            'name' => 'Nama',
            'username' => 'Username',
            'password' => 'Password',
            'confirm_password' => 'Konfirmasi Password',
            'role' => 'Role',
        ]);

        // Jika validasi gagal, kirim pesan error
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        
        $regis = User::find($request->id ?? 0) ?? new User;
        $regis->name = $request->name ?? null;
        $regis->username = $request->username ?? null;
        $regis->password = Hash::make($request->password ?? null);
        $regis->role = $request->role ?? null;
        $regis->is_active = true;
        $regis->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Registrasi Berhasil'
        ]);
    }


    public function registrasiAkunPasien(Request $request) {
        $cekusername = User::where('username', $request->username)->first();

        if ($cekusername) {
            return response()->json([
                'success' => false,
                'message' => 'Username Sudah Terdaftar, Silakan Gunakan Username Lain'
            ]);
        }

        $regis = User::find($request->id ?? 0) ?? new User;
        $regis->name = $request->name ?? null;
        $regis->username = $request->username ?? null;
        $regis->alamat = $request->alamat ?? null;
        $regis->no_wa = $request->no_wa ?? null;
        $regis->password = Hash::make($request->password ?? null);
        $regis->role = "pasien";
        $regis->is_active = true;
        $regis->save();
        
        return response()->json([
            'success' => true
        ]);
    }

    public function deleteAdmin(Request $request) {
        $del = User::find($request->id);
        $del->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil dihapus'
        ]);
    }
}
