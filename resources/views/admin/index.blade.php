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

        <div class="card shadow mt-3 ">
            <div class="card-header">
                <h4 class="card-title fw-bold">Data Pasien</h4>
            </div>
            <div class="card-body text-center">
                <div>
                    <input type="text" class="form-control" placeholder="Cari Pasien" id="cari_pasien">
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-pasien">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No Antrian</th>
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
            getPasien();

            $('#cari_pasien').on('input', function() {
                getPasien();
            })
        });
        
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0'); // Menambahkan leading zero jika tanggal kurang dari 10
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Menambahkan leading zero pada bulan
            const year = date.getFullYear();
            return `${day}-${month}-${year}`; // Format: d-m-Y
        }

        function getPasien() {
            $.ajax({
                url: '{{ route('admin.beranda.get-data-pasien') }}',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    cari_pasien: $('#cari_pasien').val()
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
                                    <td>${item.created_at ?? '-'}</td>
                                    <td>${formatDate(item.tanggal_periksa) ?? '-'}</td>
                                    <td>${item.status_pasien == true ? 'Baru' : 'Kontrol'}</td>
                                    <td>${item.status_periksa ?? '-'}</td>
                                    <td>
                                        <button onclick="updateStatusPemeriksaan(${item.pendaftaran_id})" class="btn btn-sm btn-primary" ${item.status_periksa !== "Dalam Antrian" ? 'disabled' : ''}>Mulai Periksa</a>
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

        function updateStatusPemeriksaan(pendaftaran_id) {
            $.ajax({
                url: '{{ route('admin.beranda.update-status-pemeriksaan') }}',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: '{{ csrf_token() }}',
                    pendaftaran_id: pendaftaran_id
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


    
