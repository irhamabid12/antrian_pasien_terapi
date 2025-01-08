<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body style="background-color: #b4c3d1;">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid mx-3">
             <!-- Logo dan Nama Pondok -->
            <a class="navbar-brand d-flex align-items-center" href="#">
              <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" width="50" height="50" class="d-inline-block align-text-center p-1">
              <div class="ms-2 text-wrap">
                <span class="fw-bold d-block fs-5 text-md-nowrap">Pondok Pengobatan</span>
                <span class="fw-bold d-block fs-5">Gus Arya</span>
              </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ms-auto" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto fw-medium">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pendaftaran" onclick="getAntrian()">Pendaftaran Pasien</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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
</body>

</html>
