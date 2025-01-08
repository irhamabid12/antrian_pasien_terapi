<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranT;
use Illuminate\Http\Request;

class BerandaAdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function get_data_pasien()
    {
        $data = PendaftaranT::orderBy('created_at', 'desc');

        if (request()->has('cari_pasien') == true && request('cari_pasien') != null) {
            $data = $data->where('nama_pasien', 'like', '%' . request('cari_pasien') . '%');
        }

        $data = $data->get();
    
        return response()->json([
            'data' => $data
        ]);
    }

    public function update_status_pasien (Request $request) {
        $update = PendaftaranT::where('pendaftaran_id', $request->pendaftaran_id)->first();
        $update->status_periksa = "Sudah Diperiksa";
        $update->save();
    
        return response()->json([
            'success' => true
        ]);
    }   
}
