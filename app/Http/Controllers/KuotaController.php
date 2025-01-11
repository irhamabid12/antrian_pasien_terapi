<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\KuotaJadwalOperasionalM;

class KuotaController extends Controller
{
    public function index()
    {
        $data = KuotaJadwalOperasionalM::whereDate('tanggal', '>=', Carbon::now()->format('Y-m-d'))->get();
        
        return view('admin.kuota.index', compact('data'));
    }

    public function simpan_jadwal(Request $request)
    {
        // dd($request->all());

        foreach ($request->schedule as $key => $value) {
            $date = $value['date'];
            $quota = $value['quota'];
            $operational = $value['operational'];

            // Cek apakah tanggal sudah ada di database
            $existingJadwal = KuotaJadwalOperasionalM::where('tanggal', Carbon::parse($date)->format('Y-m-d'))->first();

            if ($existingJadwal) {
                // Jika tanggal sudah terdaftar, skip iterasi ini
                continue;
            }

            $jadwal = KuotaJadwalOperasionalM::find($request->jadwal_id ?? 0) ?? new KuotaJadwalOperasionalM;
            $jadwal->tanggal = $date != null ? Carbon::parse($date)->format('Y-m-d') : null;
            $jadwal->operasional = $operational == 1 ? true : false;
            $jadwal->jumlah_kuota = $quota ?? 0;
            $jadwal->save();
        }

        return response()->json(['success' => true]);
    }
}
