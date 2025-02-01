<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PendaftaranT;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index() {
        return view('master.user.index');
    }
    public function get_antrian() {
        $today = Carbon::today();

        // Ambil semua data yang diperlukan dalam satu query
        $dataPasien = PendaftaranT::where('status_periksa', '!=', 'Sudah Diperiksa')
            ->whereDate('tanggal_periksa', $today)
            ->orderBy('nomor_antrian', 'asc')
            ->get();

        // Hitung jumlah pasien dan ambil antrian terakhir
        $all_pasien = PendaftaranT::whereDate('tanggal_periksa', $today)->count();
                    
        $jumlah_pasien = $dataPasien->count();

        // dd($dataPasien);
        return response()->json([
            'data_pasien' => $dataPasien ?? null,
            'all_pasien' => $all_pasien ?? 0,
            'jumlah_pasien' => $jumlah_pasien,
        ]);
    }
}
