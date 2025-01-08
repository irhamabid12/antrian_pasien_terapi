<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PendaftaranT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pendaftaranController extends Controller
{
    public function insert(Request $request) {
        // dd($request->all());
        // Menentukan tanggal yang diinginkan untuk pemeriksaan
        $tanggalPeriksa = Carbon::parse($request->rencana_pemeriksaan)->format('Y-m-d');

        // Tentukan jumlah pasien lainnya dari request
        $jumlahPasienLain = $request->jumlah_pasien_lain ?? 0;

        // Cek kuota berdasarkan tanggal pemeriksaan (maksimal 5 pasien, termasuk jumlah_pasien_lain)
        // Hitung jumlah pasien yang terdaftar pada tanggal tersebut, ditambah 1 untuk pasien baru
        $existingPatientCount = PendaftaranT::where('tanggal_periksa', $tanggalPeriksa)
                            ->sum(DB::raw('CAST(IFNULL(jumlah_pasien_lain, 0) + 1 AS UNSIGNED)'));

        // Jika jumlah pasien yang ada + pasien baru (termasuk jumlah_pasien_lain) sudah >= 5, kuota penuh
        if (($existingPatientCount + $jumlahPasienLain) >= 40) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota sudah penuh untuk tanggal tersebut. Silakan pilih tanggal yang lain.'
            ]);
        }
        
        $insert = PendaftaranT::find($request->pendaftaran_id ?? null) ?? new PendaftaranT;
        $insert->nama_pasien = $request->nama_pasien ?? null;
        $insert->keluhan_pasien = $request->keluhan ?? null;
        $insert->alamat_pasien = $request->alamat ?? null;
        $insert->status_pasien = $request->status_pasien == "Baru" ? true : false;
        $insert->no_telp_pasien = $request->no_wa ?? null;
        $insert->is_pasien_sendiri = (bool) $request->is_sendiri;
        if ($request->is_sendiri == false) {
            $insert->jumlah_pasien_lain = $request->jumlah_pasien_lain;
        } else {
            $insert->jumlah_pasien_lain = null;
        }
        $insert->nomor_antrian = $this->get_no_antrian();
        $insert->status_periksa = "Dalam Antrian";
        $insert->created_at = Carbon::now();
        $insert->tanggal_periksa = $tanggalPeriksa;
        $insert->save();

        return response()->json([
            'success' => true,
            'nomor_antrian' => $insert->nomor_antrian
        ]);
    }

    public function get_no_antrian () {
        $antrian = PendaftaranT::orderBy('created_at', 'desc')->first();
        
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
