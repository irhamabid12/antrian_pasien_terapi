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
        .table thead tr th {
            border: 1px solid blue;
            padding: 0px 5px 0px 5px;
            white-space: nowrap;
            background: blueviolet;
            color: white;
            text-align: center
        }

        .table tbody tr td {
            border: 1px solid blue;
            padding: 0px 5px 0px 5px;
            white-space: normal; 
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
        
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="kop-container">
        <div class="kop-content">
            <p class="kop-title">PONDOK PENGOBATAN GUS ARYA</p>
            <p class="kop-subtitle">Desa krompeng RT 03/02, Kecamatan Talun, kabupaten Pekalongan</p>
            <p class="kop-subtitle">Telp: 0856-7223-499</p>
        </div>
    </div>

    <h4 style="text-align: center; text-decoration: underline; margin:0px">DATA PENDAFTARAN PASIEN</h4>
    <h5 style="text-align: center; margin: 0px 10px 20px 10px;">Periode: {{ $periode }}</h5>

    @if (!empty($data))
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th>Nama</th>
                    <th>No. Telepon</th>
                    <th>Alamat Pasien</th>
                    <th>Tlg. Pendaftaran</th>
                    <th>Tgl. Rencana Periksa</th>
                    <th>Keluhan</th>
                    <th>Status Pasien</th>
                    <th>Status Periksa</th>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($data) --}}
                @foreach ($data as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_pasien ?? '-' }}</td>
                        <td>{{ $item->no_telp_pasien ?? '-' }}</td>
                        <td>{{ $item->alamat_pasien ?? '-' }}</td>
                        <td>{{ $item->created_at !== null ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') : '-' }}</td>
                        <td>{{ $item->tanggal_periksa ? \Carbon\Carbon::parse($item->tanggal_periksa)->format('d-m-Y') : '-' }}</td>
                        <td>{{ $item->keluhan_pasien ?? '-' }}</td>
                        <td>{{ $item->status_pasien == true ? 'Baru' : 'Kontrol' }}</td>
                        <td>{{ $item->status_periksa ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
