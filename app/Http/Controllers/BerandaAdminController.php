<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PendaftaranT;
use Illuminate\Http\Request;

class BerandaAdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function get_data_pasien( Request $request )
    {
        
        $data = PendaftaranT::orderBy('nomor_antrian', 'asc');

        if (request()->has('cari_pasien') == true && request('cari_pasien') != null) {
            $data = $data->where('nama_pasien', 'like', '%' . request('cari_pasien') . '%');
        }

        if (request()->has('tgl_praktik') == true && request('tgl_praktik') != null) {
            $data = $data->whereDate('tanggal_periksa', Carbon::parse($request->tgl_praktik)->format('Y-m-d'));
        } else {
            $data = $data->whereDate('tanggal_periksa', Carbon::now()->format('Y-m-d'));
        }

        $data = $data->where('status_periksa', '!=', 'Sudah Diperiksa');
        
        $data = $data->get();
        
        return response()->json([
            'data' => $data
        ]);
    }

    public function update_status_pasien (Request $request) {
        
        $update = PendaftaranT::where('pendaftaran_id', $request->pendaftaran_id)->first();
        $update->status_periksa = $request->status_periksa == "Dalam Antrian" ? "Sedang Diperiksa" : "Sudah Diperiksa";
        $update->updated_at = Carbon::now();
        $update->user_update_id = auth()->user()->id;
        $update->save();
    
        return response()->json([
            'success' => true
        ]);
    }   
}
