<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PendaftaranT;
use Illuminate\Http\Request;

class masterController extends Controller
{
    public function get_antrian() {
        $today = Carbon::today();

        // Ambil semua data yang diperlukan dalam satu query
        $dataPasien = PendaftaranT::where('status_periksa', '!=', 'Sudah Diperiksa')
            ->whereDate('tanggal_periksa', $today)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung jumlah pasien dan ambil antrian terakhir
        $last_antrian = $dataPasien->first()->nomor_antrian ?? null;
        $jumlah_pasien = PendaftaranT::whereDate('tanggal_periksa', $today)->count();

        // dd($dataPasien);
        return response()->json([
            'data_pasien' => $dataPasien ?? null,
            'last_antrian' => $last_antrian,
            'jumlah_pasien' => $jumlah_pasien,
        ]);
    }
}
