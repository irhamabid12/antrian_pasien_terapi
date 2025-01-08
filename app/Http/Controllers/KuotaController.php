<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KuotaJadwalOperasionalM;

class KuotaController extends Controller
{
    public function index()
    {
        return view('admin.kuota.index');
    }

    public function updateKuota(Request $request)
    {
        // Loop through days 1 to 7
        for ($i = 1; $i <= 7; $i++) {
            $hariKey = "hari{$i}";
            $switchKey = "switch" . ucfirst(strtolower($this->getHari($i)));
            $kuotaKey = "kuota" . ucfirst(strtolower($this->getHari($i)));

            // Retrieve values from the request
            $hari = $request->input($hariKey);
            $statusPraktek = $request->has($switchKey) ? 1 : 0; // Convert "on" to 1, otherwise 0
            $kuota = $request->input($kuotaKey) ?: 0; // Default to 0 if null

            // Update the record in the database
            $updateKuota = KuotaJadwalOperasionalM::find($hari);
            $updateKuota->is_open = $statusPraktek ?? 0;
            $updateKuota->jumlah_kuota = $kuota ?? 0;
            $updateKuota->save();
            
        }

        return response()->json(['success' => true]);
    }

    // Helper function to map hari index to names
    private function getHari($index)
    {
        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        return $days[$index] ?? '';
    }
}
