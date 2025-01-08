<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function index() {
        return view('register');
    }

    public function insert(Request $request) {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'is_active' => true,
            'password' => bcrypt($request->password)
        ]);
        
        return response()->json([
            'success' => true
        ]);
    }
}
