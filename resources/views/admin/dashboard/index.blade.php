@extends('layout')
@section('title', 'Dashboard | Pondok Pengobatan Gus Arya')

@section('content')
    <style>
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 10px !important;
        }

        #table-riwayat-pasien tbody tr td {
            word-wrap: break-word;
            white-space: normal;
        }

        #table-riwayat-pasien tbody tr td  {
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
    <div class="container-fluid">
        <div class="card shadow-lg border-0 mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="card-title text-start">Grafik Kunjungan Pasien Tahunan</h5>
                        <p class="fw-medium text-muted" id="keterangan_periode_grafik"></p>
                    </div>
                    <div class="ms-auto">
                        <select class="form-select border-primary" data-bs-control="select2" id="tahun_grafik">
                            <option selected>Pilih Tahun</option>
                            @foreach ($years as $item)
                                <option value="{{ $item }}" {{ $item == date('Y') ? 'selected' : ''}} >{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>

                <div class="chart-container">
                    <canvas height="70px" id="myChart"></canvas>
                </div>

            </div>
        </div>
        <div class="card shadow-lg border-0 text-center">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="card-title text-start">Jumlah Pasien</h5>
                        <p class="fw-medium text-muted" id="keterangan_periode_data"></p>
                    </div>
                    <div class="ms-auto">
                        <input type="text" placeholder="Pilih Periode Data" class="form-control border-primary datepicker" id="periode_data_pasien">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <strong class="jumlah-pasien fs-1 text-primary" id="total_pasien">0</strong>
                        <p class="label-jumlah-pasien fs-8 fw-medium text-muted">Total Pasien</p>
                    </div>
                    <div class="col">
                        <strong class="jumlah-pasien fs-1 text-primary" id="pasien_baru">0</strong>
                        <p class="label-jumlah-pasien fs-8 fw-medium text-muted">Pasien Baru</p>
                    </div>
                    <div class="col">
                        <strong class="jumlah-pasien fs-1 text-primary" id="pasien_kontrol">0</strong>
                        <p class="label-jumlah-pasien fs-8 fw-medium text-muted">Pasien Kontrol</p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <strong class="jumlah-pasien fs-1 text-primary" id="antrian_pasien">0</strong>
                        <p class="label-jumlah-pasien fs-8 fw-medium text-muted">Dalam Antrian</p>
                    </div>
                    <div class="col">
                        <strong class="jumlah-pasien fs-1 text-primary" id="sedang_diperiksa">0</strong>
                        <p class="label-jumlah-pasien fs-8 fw-medium text-muted">Sedang Diperiksa</p>
                    </div>
                    <div class="col">
                        <strong class="jumlah-pasien fs-1 text-primary" id="sudah_diperiksa">0</strong>
                        <p class="label-jumlah-pasien fs-8 fw-medium text-muted">Sudah Diperiksa</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3 mb-3">
            <div class="card-body text-center" style="overflow: auto">
                <div class="card card-body mb-3">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title text-start">Pencarian</h5>
                    </div>
                    <hr>
                    <div class="row mb-3 text-start">
                        <div class="col-12 col-md-4">
                            <div class="mb-3">
                                <label for="periode_pendaftaran" class="form-label fw-semibold">Tanggal Penanganan/Periksa</label>
                                <input type="text" placeholder="Pilih Periode Pendaftaran" class="form-control datepicker" id="periode_pendaftaran">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="mb-3">
                                <label for="status_pasien" class="form-label fw-semibold">Status Pasien</label>
                                <select class="form-select" id="status_pasien">
                                    <option value="" selected>Pilih Status Pasien</option>
                                    <option value="Semua">Semua</option>
                                    <option value="Baru">Baru</option>
                                    <option value="Kontrol">Kontrol</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="mb-3">
                                <label for="status_periksa" class="form-label fw-semibold">Status Periksa</label>
                                <select class="form-select" id="status_periksa">
                                    <option value="" selected>Pilih Status Pasien</option>
                                    <option value="Semua">Semua</option>
                                    <option value="Dalam Antrian">Dalam Antrian</option>
                                    <option value="Sudah Diperiksa">Sudah Diperiksa</option>
                                    <option value="Sedang Diperiksa">Sedang Diperiksa</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end"> 
                        <button type="button" class="btn btn-sm mx-1 btn-primary" id="btn-cari-pasien"><i class="bi bi-search"></i> Cari</button>
                        <button type="button" class="btn btn-sm mx-1 btn-success" id="btn-reset-search"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                    </div>
                    
                </div>
                <div class="card card-body table-responsive text-start">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="card-title text-start">Daftar Pasien</h5>
                            <p class="fw-medium text-muted" id="keterangan_periode_daftar_pasien"></p>
                        </div>
                        <div class="ms-auto my-3">
                            <button type="button" class="btn btn-primary btn-sm bg-gradient" onclick="printPDF()">
                                <i class="bi bi-file-earmark-pdf-fill"></i> Print PDF
                            </button>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-striped table-hover" id="table-riwayat-pasien">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>No. Telepon</th>
                                <th>Alamat Pasien</th>
                                <th>Tlg. Pendaftaran</th>
                                <th>Tgl. Rencana Periksa</th>
                                <th>Keluhan</th>
                                <th>Status Pasien</th>
                                <th>Status Periksa</th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Icon Bootstrap dengan Opacity -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.datepicker').flatpickr({
                mode: 'range',
                enableTime: false,
                dateFormat: "d-m-Y",
            });

            countPasien();
            loadDataTable();
            chartDataPasien();
        });

        $('#periode_data_pasien').on('change', function() {
            countPasien();
        });

        $('#btn-cari-pasien').on('click', function() {
            loadDataTable();
        });

        $('#btn-reset-search').on('click', function() {
            $('#periode_pendaftaran').val('');
            $('#status_pasien').val('').trigger('change');
            $('#status_periksa').val('').trigger('change');
        });

        $('#tahun_grafik').on('change', function() {
            chartDataPasien();
        });

        let myChart;
        function chartDataPasien() {
            $('#keterangan_periode_grafik').text('Grafik Pasien Tahun '+$('#tahun_grafik').val());
            $.ajax({
                url: '{{ route('admin.dashboard.chart-data') }}',
                method: 'GET',
                data : {
                    year: $('#tahun_grafik').val()
                },
                success: function(response) {
                    let labels = response.labels;
                    let data = response.data;

                    let ctx = document.getElementById('myChart').getContext('2d');

                    if (myChart) {
                        myChart.destroy();
                    }
                    myChart = new Chart(ctx, {
                        data: {
                            labels: labels,
                            datasets: [{
                                type: 'line',
                                data: data,
                                borderWidth: 2,
                            }, {
                                type: 'bar',
                                data: data,
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }   
                        }
                    });
                }
            });
        }

        function countPasien() {
            let dateRange = $('#periode_data_pasien').val().split(' to ');

            
            let startPeriode = dateRange != '' && dateRange[0] != '' ? dateRange[0] : null;
            let endPeriode = dateRange != '' && dateRange[1] != '' ? dateRange[1] : null;

            $.ajax({
                url: '{{ route('admin.dashboard.count-pasien') }}',
                method: 'GET',
                data: {
                    start_periode_data: startPeriode,
                    end_periode_data: endPeriode
                },
                success: function(response) {
                    $('#total_pasien').text(response.summary.total_pasien ?? 0);
                    $('#pasien_baru').text(response.summary.new_pasien ?? 0);
                    $('#pasien_kontrol').text(response.summary.control_pasien ?? 0);
                    $('#antrian_pasien').text(response.summary.in_queue ?? 0);
                    $('#sedang_diperiksa').text(response.summary.in_service ?? 0);
                    $('#sudah_diperiksa').text(response.summary.done_service ?? 0);
                    $('#keterangan_periode_data').text('Periode Data ' + response.periode ?? '');
                }
            });
        }


        function loadDataTable() {
            let periode_pendaftaran = $('#periode_pendaftaran').val().split(' to ');
            let startPeriode = periode_pendaftaran != '' && periode_pendaftaran[0] != '' ? periode_pendaftaran[0] : null;
            let endPeriode = periode_pendaftaran != '' && periode_pendaftaran[1] != '' ? periode_pendaftaran[1] : null;
    
            let status_pasien = $('#status_pasien').val();
            let status_periksa = $('#status_periksa').val();

            // Menginisialisasi DataTable
            var table = $('#table-riwayat-pasien').DataTable({
                "processing": false,
                "serverSide": false,
                "destroy": true,
                "dom": '<"row"<"col-sm-12 col-md-12"l>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                "responsive": true,
                "ajax": {
                    url: '{{ route('admin.dashboard.load-table-pasien') }}', // Ganti dengan URL pencarian yang sesuai
                    method: 'GET',
                    data: {
                        'start_periode_pendaftaran': startPeriode,
                        'end_periode_pendaftaran': endPeriode,
                        'status_pasien': status_pasien,
                        'status_periksa': status_periksa
                    },
                    success: function(response) {
                        $('#keterangan_periode_daftar_pasien').text('Periode Data ' + response.periode ?? '');

                        // Memformat data untuk DataTable
                        var data = response.dataPasien.map(function(data, index) {
                            return [
                                index + 1,
                                '<td class="text-start">' + (data.nama_pasien ?? '-') + '</td>',
                                data.no_telp_pasien ?? '-',
                                data.alamat_pasien ?? '-',
                                data.created_at ?? '-',
                                data.tanggal_periksa ?? '-',
                                data.keluhan_pasien ?? '-',
                                data.status_periksa ?? '-',
                                data.status_periksa ?? '-',
                                // '<a href="#" class="btn btn-info btn-sm">Detail</a>'
                            ];
                        });

                        // Mengisi DataTable dengan data yang baru
                        table.clear();
                        table.rows.add(data);
                        table.draw();
                    }
                }
            });
        }

        function printPDF() {
            let periode_pendaftaran = $('#periode_pendaftaran').val().split(' to ');
            let startPeriode = periode_pendaftaran != '' && periode_pendaftaran[0] != '' ? periode_pendaftaran[0] : null;
            let endPeriode = periode_pendaftaran != '' && periode_pendaftaran[1] != '' ? periode_pendaftaran[1] : null;
    
            let status_pasien = $('#status_pasien').val();
            let status_periksa = $('#status_periksa').val();

            let parameters = 'start_periode_pendaftaran=' + startPeriode + '&end_periode_pendaftaran=' + endPeriode + '&status_pasien=' + status_pasien + '&status_periksa=' + status_periksa;
            let url = '{{ route('admin.dashboard.print-pdf') }}?'+parameters;
            window.open(url, '_blank');
            
            
        }
    </script>
@endsection
