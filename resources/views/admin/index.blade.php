@extends('layout2')
@section('title', 'Beranda')

@section('content')
    
    @include('admin.navbar')

    <div class="container mt-3">
        <div class="row">
            <div class="col">
                <div class="card shadow"
                    style="background: linear-gradient(to right, #4caf50, #81c784); position: relative; overflow: hidden;">
                    <div class="card-body text-white text-center">
                        <i class="bi bi-ticket-perforated display-5"></i>
                        <br>
                        <span class="col-12 fw-bold" style="font-size: 50px;" id="antrian_pasien">0</span>
                        <br>
                        <h4 class="col-12">Nomor Antrian Sekarang</h4>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow"
                    style="background: linear-gradient(to right, #1b236e, #5963b4); position: relative; overflow: hidden;">
                    <div class="card-body text-white text-center">
                        <i class="bi bi-person-vcard display-5"></i>
                        <br>
                        <span class="col-12 fw-bold" style="font-size: 50px;" id="jumlah_pasien">0</span>
                        <br>
                        <h4 class="col-12">Jumlah Pasien</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3 mb-3">
            <div class="card-header">
                <h4 class="card-title fw-bold">Data Pasien</h4>
            </div>
            <div class="card-body text-center" style="overflow: auto">
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label for="cari_pasien" class="col-form-label fw-bold col-4 text-start">Nama Pasien</label>
                            <div class="col-8">
                                <input type="text" class="form-control" placeholder="Cari Pasien" id="cari_pasien">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label for="tgl_praktik" class="col-form-label fw-bold col-4 text-start">Tanggal Praktik</label>
                            <div class="col-8">
                                <input type="date" class="form-control" id="tgl_praktik">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-pasien">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>No. Antrian</th>
                                <th>No Wa</th>
                                <th>Jumlah Pasien</th>
                                <th>Tlg. Pendaftaran</th>
                                <th>Tgl. Rencana Periksa</th>
                                <th>Status Pasien</th>
                                <th>Status Periksa</th>
                                <th>Aksi</th>
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
        $(document).ready(function() {
            getAntrian();

            setInterval(function() {
                getAntrian();
            }, 5000);
        });
        function getAntrian() {
            $.ajax({
                url: "{{ route('get_antrian') }}",
                method: "GET",
                dataType: "JSON",
                success: function(response) {
                    $('#antrian_pasien').text(response.last_antrian ?? 0);
                    $('#jumlah_pasien').text(response.jumlah_pasien ?? 0);
                }
            });
        }
    </script>
    
    <script>
        $(document).ready(function() {
            getPasien();

            $('#cari_pasien').on('input', function() {
                getPasien();
            });

            $('#tgl_praktik').flatpickr({
                dateFormat: "d-m-Y",
                defaultDate: new Date()
            });
        });

        $('#tgl_praktik').on('change', function() {
            getPasien();
        });
        
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0'); // Menambahkan leading zero jika tanggal kurang dari 10
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Menambahkan leading zero pada bulan
            const year = date.getFullYear();
            return `${day}-${month}-${year}`; // Format: d-m-Y
        }

        function formatDateTime(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0'); // Menambahkan leading zero jika tanggal kurang dari 10
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Menambahkan leading zero pada bulan
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0'); // Menambahkan leading zero jika jam kurang dari 10
            const minutes = String(date.getMinutes()).padStart(2, '0'); // Menambahkan leading zero pada menit
            return `${day}-${month}-${year} ${hours}:${minutes}`; // Format: d-m-Y H:i
        }

        function getPasien() {
            $.ajax({
                url: '{{ route('admin.beranda.get-data-pasien') }}',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    cari_pasien: $('#cari_pasien').val(),
                    tgl_praktik: $('#tgl_praktik').val()
                },
                success: function(response) {
                    if (response.data.length > 0) {
                        $('#table-pasien tbody').empty();
                        let no = 1;
                        response.data.forEach(function(item) {
                            $('#table-pasien tbody').append(`
                                <tr>
                                    <td>${no}</td>
                                    <td>${item.nama_pasien ?? '-'}</td>
                                    <td>${item.nomor_antrian ?? '-'}</td>
                                    <td>${item.no_telp_pasien ?? '-'}</td>
                                    <td>${item.is_pasien_sendiri == true ? '1' : (item.jumlah_pasien_lain ?? '0')}</td>
                                    <td>${item.created_at != null ? formatDateTime(item.created_at) : '-'}</td>
                                    <td>${item.tanggal_periksa != null ? formatDate(item.tanggal_periksa) : '-'}</td>
                                    <td>${item.status_pasien == true ? 'Baru' : 'Kontrol'}</td>
                                    <td>${item.status_periksa ?? '-'}</td>
                                    <td>
                                        <button onclick="updateStatusPemeriksaan(${item.pendaftaran_id}, '${item.status_periksa}')" class="btn btn-sm ${item.status_periksa == "Dalam Antrian" ? 'btn-primary' : 'btn-danger'}">${item.status_periksa == "Dalam Antrian" ? 'Mulai Periksa' : 'Selesai Periksa'}</a>
                                    </td>
                                </tr>
                            `);
                            no++;
                        });
                    } else {
                        $('#table-pasien tbody').empty();
                        $('#table-pasien tbody').append(`
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data pasien</td>
                            </tr>
                        `);
                    }
                }
            });
        }

        function updateStatusPemeriksaan(pendaftaran_id, status_periksa) {
            $.ajax({
                url: '{{ route('admin.beranda.update-status-pemeriksaan') }}',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: '{{ csrf_token() }}',
                    pendaftaran_id: pendaftaran_id,
                    status_periksa: status_periksa
                },
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Status pemeriksaan berhasil diubah!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }). then((result) => {
                            if (result.isConfirmed) {
                                getPasien();
                            }
                        })
                    }
                }        
            });
        }
    </script>

    
@endsection


    
