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

    <!-- Tambahkan CSS Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;        }
    </style>
</head>

<body style="background-color: #b4c3d1;">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid mx-3">
             <!-- Logo dan Nama Pondok -->
            <a class="navbar-brand d-flex align-items-center" href="{{url('/pasien/beranda')}}">
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
                        <a class="nav-link active" aria-current="page" href="{{url('/pasien/beranda')}}"><i class="bi bi-house-door-fill"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('pasien/pendaftaran/index')}}" onclick="getAntrian()"><i class="bi bi-pencil-square"></i> Pendaftaran Pasien</a>
                    </li>
                    
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('pasien/pendaftaran/riwayat')}}"><i class="bi bi-table"></i> Riwayat Pendaftaran</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-workspace"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('pasien/logout') }}"><i class="bi bi-box-arrow-in-right"></i> logout</a></li>
                            </ul>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/registrasi/index') }}">Daftar</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Tambahkan JS Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>

</html>
