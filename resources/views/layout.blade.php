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
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #b4c3d1;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;        
        }

        .dataTables_wrapper .dataTables_length {
            margin-bottom: 10px !important;
        }

        main {
            flex-grow: 1;
        }


    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> --}}
    
    <!-- DataTables CSS (with Bootstrap integration) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap 4 Integration -->
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>



</head>

<body>
    <header>
        <nav class="navbar nav-underline bg-body-tertiary">
            <div class="container-fluid">
                 <!-- Logo dan Nama Pondok -->
                <a class="navbar-brand d-flex align-items-center" href="{{url('/pasien/beranda')}}">
                  <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" width="50" height="50" class="d-inline-block align-text-center p-1">
                  <div class="ms-2 text-wrap">
                    <span class="fw-bold d-block fs-5 text-md-nowrap p-0">PONDOK PENGOBATAN GUS ARYA</span>
                    {{-- <span class="fw-bold d-block fs-5 p-0"></span> --}}
                  </div>
                </a>
                {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}
                <div class="px-3">
                    <ul class="navbar-nav me-auto fw-medium d-flex ">
                        {{-- <li class="nav-item">
                            <a class="nav-link" aria-current="page" onclick="getAntrian()" href="{{url('/pasien/beranda')}}"><i class="bi bi-house-door-fill"></i> Beranda</a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{url('pasien/pendaftaran/index')}}"><i class="bi bi-pencil-square"></i> Pendaftaran Pasien</a>
                        </li> --}}
                        
                        @auth
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{url('pasien/pendaftaran/riwayat')}}"><i class="bi bi-table"></i> Riwayat Pendaftaran</a>
                            </li> --}}
                            <li class="nav-item dropdown">
                                <a class="btn btn-info dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
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
                                <a class="nav-link" href="{{ url('/registrasi/index') }}">Daftar Akun</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="nav-scroller bg-body shadow-sm">
            <nav class="container-fluid px-3 nav py-2 nav-pills flex-column flex-sm-row overflow-auto fw-medium" style="display: flex; overflow-x: scroll; white-space: nowrap;">
                @guest
                    <a class="nav-link {{ Request::is('pasien/beranda') ? 'active' : '' }}" href="{{ url('/pasien/beranda') }}">Beranda Pasien</a>
                @endguest
                @auth
                    <a class="nav-link {{ Request::is('pasien/beranda') ? 'active' : '' }}" href="{{ url('/pasien/beranda') }}">Beranda Pasien</a>

                    @canany('superadmin')
                        <a class="nav-link {{ Request::is('admin/master/index') ? 'active' : '' }}" href="{{ url('/admin/master/index') }}">Master User</a>
                        <a class="nav-link {{ Request::is('admin/dashboard/index') ? 'active' : '' }}" href="{{ url('/admin/dashboard/index') }}">Dashboard</a>
                        <a class="nav-link {{ Request::is('admin/product/index') ? 'active' : '' }}" href="{{ url('/admin/product/index') }}">Product</a>
                    @endcanany
                    @canany(['admin', 'superadmin'])
                        <a class="nav-link {{ Request::is('admin/beranda/index') ? 'active' : '' }}" href="{{url('/admin/beranda/index')}}">Daftar Pasien</a>
                        <a class="nav-link {{ Request::is('admin/kuota/index') ? 'active' : '' }}" href="{{url('/admin/kuota/index')}}">Kuota dan Jadwal Operasional</a>
                    @endcanany
                    <a class="nav-link {{ Request::is('pasien/pendaftaran/index') ? 'active' : '' }}" href="{{ url('pasien/pendaftaran/index') }}">Pendaftaran Pasien</a>
                    <a class="nav-link {{ Request::is('pasien/pendaftaran/riwayat') ? 'active' : '' }}" href="{{ url('pasien/pendaftaran/riwayat') }}">Riwayat Pendaftaran</a>
                @endauth
                    
            </nav>
        </div>
    </header>

    <main class="container-fluid my-3">
        @yield('content')
    </main>
    
    <footer class="py-3 bg-body-tertiary">
        <p class="text-center">Pondok Pengobatan Gus Arya - Copyright &copy; 2025</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Tambahkan JS Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</body>

</html>
