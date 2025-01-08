<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    public function index() {
        return view('admin.register');
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
}
