@extends('layout')
@section('title', 'Beranda Pasien | Pondok Pengobatan Gus Arya')

@section('content')
    <div class="container-fluid mt-3">
        <div class="card card-body shadow">
            <div class="row">
                <div class="col">
                    <div class="card shadow bg-success bg-gradient border-0">
                        <div class="card-body text-white text-center">
                            <i class="bi bi-ticket-perforated display-5"></i>
                            <br>
                            <span class="col-12 fw-bold" style="font-size: 50px;" id="antrian_pasien">0</span>
                            <br>
                            <h4 class="col-12">Total Antrian</h4>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow bg-primary bg-gradient border-0">
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
        </div>

        <div class="card shadow mt-3" style="height: 300px">
            <div class="card-body text-center" style="overflow: auto">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-list-antrian-pasien">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>No Antrian</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-body text-center">
                <h3 class="card-title fw-bold">Pondok Pengobatan Gus Arya</h3>
                <iframe width="100%" height="300"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.103852131728!2d109.72361807442098!3d-6.9970496685278025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70230015aafcd5%3A0x2f73c776c22a73ca!2sPONDOK%20PENGOBATAN%20GUS%20ARYA!5e0!3m2!1sid!2sid!4v1736236239102!5m2!1sid!2sid"style="border:0;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <p class="card-text mt-3">
                    <strong>Alamat:</strong> Desa krompeng RT 03/02, Kecamatan Talun, kabupaten Pekalongan.<br>
                    <strong>Informasi/Konsultasi:</strong> 0856-7223-499<br>
                </p>
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
                    if (response.data_pasien.length > 0) {
                        $('#table-list-antrian-pasien tbody').empty();
                        let no = 1;
                        response.data_pasien.forEach(function(item) {
                            $('#table-list-antrian-pasien tbody').append(`
                                <tr>
                                    <td>${no}</td>
                                    <td>${item.nama_pasien ?? '-'}</td>
                                    <td>${item.nomor_antrian ?? '-'}</td>
                                </tr>
                            `);
                            no++;
                        });
                    } else {
                        $('#table-list-antrian-pasien tbody').empty();
                        $('#table-list-antrian-pasien tbody').append(`
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data pasien</td>
                            </tr>
                        `);
                    }

                    $('#antrian_pasien').text(response.all_pasien ?? 0);
                    $('#jumlah_pasien').text(response.jumlah_pasien ?? 0);
                }
            });
        }
    </script>
    
@endsection


    
