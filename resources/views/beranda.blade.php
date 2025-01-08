@extends('layout')
@section('title', 'Beranda')

@section('content')
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
            <div class="card-body text-center">
                <h3 class="card-title fw-bold">Pondok Pengobatan Gus Arya</h3>
                <div class="ratio ratio-16x9">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.103852131728!2d109.72361807442098!3d-6.9970496685278025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70230015aafcd5%3A0x2f73c776c22a73ca!2sPONDOK%20PENGOBATAN%20GUS%20ARYA!5e0!3m2!1sid!2sid!4v1736236239102!5m2!1sid!2sid"style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <p class="card-text mt-3">
                    <strong>Alamat:</strong> Desa krompeng RT 03/02, Kecamatan Talun, kabupaten Pekalongan.<br>
                    <strong>Informasi/Konsultasi:</strong> 0856-7223-499<br>
                </p>
            </div>
            <!-- Icon Bootstrap dengan Opacity -->
        </div>
    </div>

    
@endsection


    
