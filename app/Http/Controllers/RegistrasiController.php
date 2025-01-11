<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    public function index() {
        return view('akun.register');
    }

    public function insert(Request $request) {
        // dd($request->all());
        $regis = User::find($request->id ?? 0) ?? new User;
        $regis->name = $request->name ?? null;
        $regis->username = $request->username ?? null;
        $regis->password = Hash::make($request->password ?? null);
        $regis->role = $request->role ?? 'admin';
        $regis->is_active = true;
        $regis->save();
        
        return response()->json([
            'success' => true
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
}
