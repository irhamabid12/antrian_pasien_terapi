<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\PendaftaranT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KuotaJadwalOperasionalM;

class pendaftaranController extends Controller
{

    public function index() {
        return view('pendaftaran');
    }

    public function riwayat () {
        $dataRiwayat = PendaftaranT::with('pasienlain')
                    ->where('status_periksa', '!=', 'Sudah Diperiksa')
                    ->where('user_create_id', auth()->user()->id)
                    ->where('pasien_parent_id', null)
                    ->where('tanggal_periksa', '>=', Carbon::now()->format('Y-m-d'))
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('riwayat_pendaftaran', [
            'data_riwayat' => $dataRiwayat
        ]);
    }
    
    public function insert(Request $request) {
         
        if (!$request->rencana_pemeriksaan) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan pilih tanggal pemeriksaan.'
            ]);
        }

        // Menentukan tanggal yang diinginkan untuk pemeriksaan
        $tanggalPeriksa = Carbon::parse($request->rencana_pemeriksaan)->format('Y-m-d');

        $jadwal = KuotaJadwalOperasionalM::where('operasional', true)->whereDate('tanggal', $tanggalPeriksa)->first();
        
        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada jadwal operasional untuk tanggal tersebut. Silakan pilih tanggal yang lain.'
            ]);
        }

        // Tentukan jumlah pasien lainnya dari request
        $jumlahPasienLain = $request->jumlah_pasien_lain ?? 0;

        // Cek kuota berdasarkan tanggal pemeriksaan (maksimal 5 pasien, termasuk jumlah_pasien_lain)
        // Hitung jumlah pasien yang terdaftar pada tanggal tersebut, ditambah 1 untuk pasien baru
        $existingPatientCount = PendaftaranT::where('tanggal_periksa', $tanggalPeriksa)
                            ->where('status_periksa', 'Dalam Antrian')
                            ->sum(DB::raw('CAST(IFNULL(jumlah_pasien_lain, 0) + 1 AS UNSIGNED)'));
        
        // Jika jumlah pasien yang ada + pasien baru (termasuk jumlah_pasien_lain) sudah >= 5, kuota penuh
        if (($existingPatientCount + $jumlahPasienLain) >= $jadwal->jumlah_kuota) {
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
        $insert->user_create_id = auth()->user()->id;
        $insert->tanggal_periksa = $tanggalPeriksa;
        $insert->save();
       
        if ($request->is_sendiri == "false" && $request->jumlah_pasien_lain > 0) {
            foreach ($request->nama_pasien_lain as $key => $value) {
                $insert_add = new PendaftaranT;
                $insert_add->nama_pasien = $value ?? null;
                $insert_add->keluhan_pasien = $request->keluhan_pasien_lain[$key] ?? null;
                $insert_add->alamat_pasien = $insert->alamat_pasien ?? null;
                $insert_add->status_pasien = $insert->status_pasien ?? null;
                $insert_add->no_telp_pasien = $insert->no_telp_pasien ?? null;
        
                // Generate nomor antrian baru untuk setiap pasien tambahan
                $insert_add->nomor_antrian = $this->get_no_antrian(); 
        
                $insert_add->status_periksa = "Dalam Antrian";
                $insert_add->created_at = Carbon::now();
                $insert_add->user_create_id = auth()->user()->id;
                $insert_add->tanggal_periksa = $insert->tanggal_periksa;
                $insert_add->is_pasien_lain = true;
                $insert_add->pasien_parent_id = $insert->pendaftaran_id;
                $insert_add->save();
            }
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function get_no_antrian () {
        $antrian = PendaftaranT::orderBy('pendaftaran_id', 'desc')->first();

        if ($antrian != null) {
            // Menambahkan 1 ke nomor antrian terakhir dan memastikan formatnya tiga digit
            $nomor_antrian = str_pad($antrian->nomor_antrian + 1, 3, '0', STR_PAD_LEFT);
    
            return $nomor_antrian;
        } else {
            // Jika tidak ada antrian sebelumnya, mulai dari 001
            return '001';
        }
    }

    public function cetakBuktiPendaftaran (Request $request) {
        $pendaftaran = PendaftaranT::with('pasienlain')->where('pendaftaran_id', $request->pendaftaran_id)->first();

        $pdf = PDF::loadView('bukti_pendaftaran', [
            'data_pendaftaran' => $pendaftaran
        ]);

        return $pdf->stream('bukti-pendaftaran.pdf');
    }
}
