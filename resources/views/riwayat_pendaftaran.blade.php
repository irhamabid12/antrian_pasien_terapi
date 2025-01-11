@extends('layout')
@section('title', 'Riwayat Pendaftaran Pasien')


@section('content')
    <div class="container mt-3">

        <div class="card shadow mt-3">
            <div class="card-body text-start p-3">
                <h4 class="card-title fw-bold mb-3 text-center">Riwayat Pendaftaran Pasien</h4>
                @if ($data_riwayat->isEmpty() == false)
                    @foreach ($data_riwayat as $item)
                        <div class="card mb-3"> 
                            <div class="card-body text-start" style="overflow: auto">
                                <table class="table" style="border-color: transparent">
                                    <tbody>
                                        <tr>
                                            <th class="text-start" width="20%">Nama Pasien</th>
                                            <td class="text-start">: {{ $item->nama_pasien ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Alamat</th>
                                            <td class="text-start">: {{ $item->alamat_pasien ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">No. Telepon</th>
                                            <td class="text-start">: {{ $item->no_telp_pasien ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Tanggal Periksa</th>
                                            <td class="text-start">: {{ \Carbon\Carbon::parse($item->tanggal_periksa)->isoFormat('dddd, D MMMM Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Keluhan</th>
                                            <td class="text-start">: {{ $item->keluhan_pasien ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">No. Antrian</th>
                                            <td class="text-start">: {{ $item->nomor_antrian ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                @if ($item->pasienlain->isEmpty() == false)
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="4">Pasien Tambahan</th>
                                            </tr>
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th>Nama</th>
                                                <th>Keluhan</th>
                                                <th>No. Antrian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->pasienlain as $key => $itempasienlain)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $itempasienlain->nama_pasien ?? '-' }}</td>
                                                    <td>{{ $itempasienlain->keluhan_pasien ?? '-' }}</td>
                                                    <td>{{ $itempasienlain->nomor_antrian ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('pasien.pendaftaran.cetak-bukti-pendaftaran', ['pendaftaran_id' => $item->pendaftaran_id]) }}" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-file-earmark-pdf"></i> Cetak Bukti Pendaftaran</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">Belum ada riwayat pendaftaran pasien.</p>
                @endif
            </div>
        </div>
    </div>
@endsection




    
