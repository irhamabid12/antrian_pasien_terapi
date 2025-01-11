<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid transparent;
            padding: 8px;
        }
        .table th {
            background-color: transparent;
            text-align: left;
        }

        body {
            font-family: Arial, sans-serif;
        }
        .kop-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .kop-logo {
            flex: 0 0 100px;
        }
        .kop-logo img {
            width: 100%;
            height: auto;
        }
        .kop-content {
            flex: 1;
            text-align: center;
        }
        .kop-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .kop-subtitle {
            font-size: 14px;
            margin: 0;
        }
        
        .table-bordered {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="kop-container">
        {{-- <div class="kop-logo">
            <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo">
        </div> --}}
        <div class="kop-content">
            <p class="kop-title">PONDOK PENGOBATAN GUS ARYA</p>
            <p class="kop-subtitle">Desa krompeng RT 03/02, Kecamatan Talun, kabupaten Pekalongan</p>
            <p class="kop-subtitle">Telp: 0856-7223-499</p>
        </div>
    </div>

    <h2 style="text-align: center;">BUKTI PENDAFTARAN</h2>

    @if (!empty($data_pendaftaran))
        <table class="table">
            <tr>
                <th width="20%">Nama Pasien</th>
                <td>: {{ $data_pendaftaran->nama_pasien ?? '-' }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>: {{ $data_pendaftaran->alamat_pasien ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. Telepon</th>
                <td>: {{ $data_pendaftaran->no_telp_pasien ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Periksa</th>
                <td>: {{ \Carbon\Carbon::parse($data_pendaftaran->tanggal_periksa)->isoFormat('dddd, D MMMM Y') }}</td>
            </tr>
            <tr>
                <th>Keluhan</th>
                <td>: {{ $data_pendaftaran->keluhan_pasien ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. Antrian</th>
                <td>: {{ $data_pendaftaran->nomor_antrian ?? '-' }}</td>
            </tr>
        </table>
        @if (!$data_pendaftaran->pasienlain->isEmpty())
            <h4>Pasien Tambahan</h4>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th>Nama</th>
                        <th>Keluhan</th>
                        <th>No. Antrian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_pendaftaran->pasienlain as $key => $itempasienlain)
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
    @endif
</body>
</html>
