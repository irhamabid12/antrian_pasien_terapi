<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranT;
use Illuminate\Http\Request;

class masterController extends Controller
{
    public function get_antrian() {
        $antrian = PendaftaranT::where('status_periksa', 'Dalam Antrian')
                ->orderBy('created_at', 'desc')
                ->first();
        
        $count_antrian = PendaftaranT::where('status_periksa', 'Dalam Antrian')
                        ->count();
        
        $last_antrian = null;
        $jumlah_pasien = null;
        if ($antrian != null) {
            $last_antrian = $antrian->nomor_antrian;
            $jumlah_pasien = $count_antrian;
        }

        return response()->json([
            'last_antrian' => $last_antrian,
            'jumlah_pasien' => $jumlah_pasien
        ]);
    }
}
