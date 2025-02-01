<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\PendaftaranT;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $years = range(date('Y'), 2024);

        $dataPasien = PendaftaranT::all();

        return view('admin.dashboard.index', compact('years'));
    }

    public function chart_data(Request $request)
    {
        // dd($request->all());
        $data = PendaftaranT::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $request->year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray();

            // Isi default 0 untuk bulan yang tidak ada data
            $formattedData = [];
            for ($i = 1; $i <= 12; $i++) {
                $formattedData[] = $data[$i] ?? 0;
            }

            // dd($formattedData);
            return response()->json([
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'data' => $formattedData,
                'year' => $request->year ?? date('Y')
            ]);
    }   

    public function jumlah_pasien(Request $request)
    {   
        // dd($request->all());
        if ($request->start_periode_data != null && $request->end_periode_data != null) {
            
            $start_periode_data = Carbon::parse($request->start_periode_data)->createFromFormat('d-m-Y', $request->start_periode_data)->format('Y-m-d');
            $end_periode_data = Carbon::parse($request->end_periode_data)->createFromFormat('d-m-Y', $request->end_periode_data)->format('Y-m-d');
        
            $summary = PendaftaranT::whereBetween('tanggal_periksa', [$start_periode_data, $end_periode_data])
                ->selectRaw("
                    COUNT(*) as total_pasien,
                    SUM(CASE WHEN status_pasien = true THEN 1 ELSE 0 END) as new_pasien,
                    SUM(CASE WHEN status_pasien = false THEN 1 ELSE 0 END) as control_pasien,
                    SUM(CASE WHEN status_periksa = 'Dalam Antrian' THEN 1 ELSE 0 END) as in_queue,
                    SUM(CASE WHEN status_periksa = 'Sedang Diperiksa' THEN 1 ELSE 0 END) as in_service,
                    SUM(CASE WHEN status_periksa = 'Sudah Diperiksa' THEN 1 ELSE 0 END) as done_service
                ")
                ->first();

            $periode = Carbon::parse($start_periode_data)->isoFormat('dddd, D MMMM Y') . ' - ' . Carbon::parse($end_periode_data)->isoFormat('dddd, D MMMM Y');
        } elseif ($request->start_periode_data != null && $request->end_periode_data == null) {
            
            $start_periode_data = Carbon::parse($request->start_periode_data)->createFromFormat('d-m-Y', $request->start_periode_data)->format('Y-m-d');

            $summary = PendaftaranT::whereDate('tanggal_periksa', $start_periode_data)
                ->selectRaw("
                    COUNT(*) as total_pasien,
                    SUM(CASE WHEN status_pasien = true THEN 1 ELSE 0 END) as new_pasien,
                    SUM(CASE WHEN status_pasien = false THEN 1 ELSE 0 END) as control_pasien,
                    SUM(CASE WHEN status_periksa = 'Dalam Antrian' THEN 1 ELSE 0 END) as in_queue,
                    SUM(CASE WHEN status_periksa = 'Sedang Diperiksa' THEN 1 ELSE 0 END) as in_service,
                    SUM(CASE WHEN status_periksa = 'Sudah Diperiksa' THEN 1 ELSE 0 END) as done_service
                ")
                ->first();

            $periode = Carbon::parse($start_periode_data)->isoFormat('dddd, D MMMM Y');
        } else {
            $today = Carbon::today();
    
            $summary = PendaftaranT::whereDate('tanggal_periksa', $today)
                    ->selectRaw("
                        COUNT(*) as total_pasien,
                        SUM(CASE WHEN status_pasien = true THEN 1 ELSE 0 END) as new_pasien,
                        SUM(CASE WHEN status_pasien = false THEN 1 ELSE 0 END) as control_pasien,
                        SUM(CASE WHEN status_periksa = 'Dalam Antrian' THEN 1 ELSE 0 END) as in_queue,
                        SUM(CASE WHEN status_periksa = 'Sedang Diperiksa' THEN 1 ELSE 0 END) as in_service,
                        SUM(CASE WHEN status_periksa = 'Sudah Diperiksa' THEN 1 ELSE 0 END) as done_service
                    ")
                    ->first();

            $periode = Carbon::now()->isoFormat('dddd, D MMMM Y');
        }

        return response()->json([
            'summary' => $summary,
            'periode' => $periode
        ]);
    }

    public function load_table_pasien(Request $request){

        $dataPasien = PendaftaranT::select('*');

        if ($request->start_periode_pendaftaran != null && $request->end_periode_pendaftaran != null) {
            $start_periode_pendaftaran = Carbon::parse($request->start_periode_pendaftaran)->createFromFormat('d-m-Y', $request->start_periode_pendaftaran)->format('Y-m-d');
            $end_periode_pendaftaran = Carbon::parse($request->end_periode_pendaftaran)->createFromFormat('d-m-Y', $request->end_periode_pendaftaran)->format('Y-m-d');

            $dataPasien = $dataPasien->whereBetween('tanggal_periksa', [$start_periode_pendaftaran, $end_periode_pendaftaran]);

            $periode = Carbon::parse($start_periode_pendaftaran)->isoFormat('dddd, D MMMM Y') . ' - ' . Carbon::parse($end_periode_pendaftaran)->isoFormat('dddd, D MMMM Y');
        } elseif ($request->start_periode_pendaftaran != null && $request->end_periode_pendaftaran == null) {
            $start_periode_pendaftaran = Carbon::parse($request->start_periode_pendaftaran)->createFromFormat('d-m-Y', $request->start_periode_pendaftaran)->format('Y-m-d');
            
            $dataPasien = $dataPasien->where('tanggal_periksa', $start_periode_pendaftaran);

            $periode = Carbon::parse($start_periode_pendaftaran)->isoFormat('dddd, D MMMM Y');
        } else {
            $dataPasien = $dataPasien->whereDate('tanggal_periksa', Carbon::today());

            $periode = Carbon::now()->isoFormat('dddd, D MMMM Y');
        }

        if ($request->status_pasien != null && $request->status_pasien != 'Semua') {
            $dataPasien = $dataPasien->where('status_pasien', $request->status_pasien == 'Baru' ? true : false);
        }

        if ($request->status_periksa != null && $request->status_periksa != 'Semua') {
            $dataPasien = $dataPasien->where('status_periksa', $request->status_periksa);
        }

        $dataPasien = $dataPasien->get();

        return response()->json([
            'dataPasien' => $dataPasien,
            'periode' => $periode
        ]);
    }

    public function print_pdf(Request $request){
        $dataPasien = PendaftaranT::select('*');

        if ($request->start_periode_pendaftaran != "null" && $request->end_periode_pendaftaran != "null") {
            $start_periode_pendaftaran = Carbon::parse($request->start_periode_pendaftaran)->createFromFormat('d-m-Y', $request->start_periode_pendaftaran)->format('Y-m-d');
            $end_periode_pendaftaran = Carbon::parse($request->end_periode_pendaftaran)->createFromFormat('d-m-Y', $request->end_periode_pendaftaran)->format('Y-m-d');

            $dataPasien = $dataPasien->whereBetween('tanggal_periksa', [$start_periode_pendaftaran, $end_periode_pendaftaran]);
        } elseif ($request->start_periode_pendaftaran != "null" && $request->end_periode_pendaftaran == "null") {
            $start_periode_pendaftaran = Carbon::parse($request->start_periode_pendaftaran)->createFromFormat('d-m-Y', $request->start_periode_pendaftaran)->format('Y-m-d');
            
            $dataPasien = $dataPasien->where('tanggal_periksa', $start_periode_pendaftaran);
        } else {
            $dataPasien = $dataPasien->whereDate('tanggal_periksa', Carbon::today());
        }

        if ($request->status_pasien != null && $request->status_pasien != 'Semua') {
            $dataPasien = $dataPasien->where('status_pasien', $request->status_pasien == 'Baru' ? true : false);
        }

        if ($request->status_periksa != null && $request->status_periksa != 'Semua') {
            $dataPasien = $dataPasien->where('status_periksa', $request->status_periksa);
        }

        $dataPasien = $dataPasien->limit(200)->get();

        $pdf = PDF::loadView('admin.dashboard.pdf.data_pasien', [
            'data' => $dataPasien,
            'periode' => Carbon::now()->format('d-m-Y')
        ]);

        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('data_pasien.pdf');
    }
}
