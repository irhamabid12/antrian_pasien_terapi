<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PendaftaranT;
use Illuminate\Http\Request;

class pendaftaranController extends Controller
{
    public function insert(Request $request) {
        $insert = PendaftaranT::find($request->pendaftaran_id ?? null) ?? new PendaftaranT;
        $insert->nama_pasien = $request->nama_pasien ?? null;
        $insert->keluhan_pasien = $request->keluhan ?? null;
        $insert->alamat_pasien = $request->alamat ?? null;
        $insert->status_pasien = $request->status_pasien == "Baru" ? true : false;
        $insert->no_telp_pasien = $request->no_wa ?? null;
        $insert->is_pasien_sendiri = (bool) $request->is_pasien_sendiri;
        if ($request->is_sendiri == true) {
            $insert->jumlah_pasien_lain = $request->jumlah_pasien_lain;
        } else {
            $insert->jumlah_pasien_lain = null;
        }
        $insert->nomor_antrian = $this->get_no_antrian();
        $insert->status_periksa = "Dalam Antrian";
        $insert->created_at = Carbon::now();
        $insert->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function get_no_antrian () {
        $antrian = PendaftaranT::where('status_periksa', 'Dalam Antrian')
                ->orderBy('created_at', 'desc')
                ->first();
        
        if ($antrian != null) {
            // Menambahkan 1 ke nomor antrian terakhir dan memastikan formatnya tiga digit
            $nomor_antrian = str_pad($antrian->nomor_antrian + 1, 3, '0', STR_PAD_LEFT);
    
            return $nomor_antrian;
        } else {
            // Jika tidak ada antrian sebelumnya, mulai dari 001
            return '001';
        }
    }
}
