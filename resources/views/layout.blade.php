<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pondok Pengobatan Gus Arya - salah satu pondok pengobatan alternatif di Indonesia.">
    <meta name="keywords" content="Pondok Pengobatan Gus Arya, Pondok Pengobatan Alternatif, Pengobatan Alternatif, Pengobatan Alternatif Indonesia, Pondok Pengobatan Alternatif Indonesia, Pondok Pengobatan, Pengobatan, Pengobatan Alternatif kabupaten Pekalongan">
    <meta name="author" content="Aitech Indonesia">
    <title>@yield('title', 'Nama Perusahaan')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo.jpg') }}" type="image/x-icon">

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
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#myModalProfil"><i class="bi bi-person-circle"></i> Profil</a></li>
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#myModalPassword"><i class="bi bi-gear"></i> Ganti Password</a></li>
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

        @auth

        {{-- @dd(auth()->user()) --}}
            <!-- Modal Profil -->
            <div class="modal fade" id="myModalProfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 me-2 ">User Profil</h1>
                        @if (auth()->user()->role === 'superadmin')
                            <span class="badge text-bg-primary bg-gradient">Super Admin</span>  
                        @elseif (auth()->user()->role === 'admin')
                            <span class="badge text-bg-secondary bg-gradient">Admin</span> 
                        @else
                            <span class="badge text-bg-info bg-gradient">Pasien</span>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        @if (auth()->user()->updated_at == auth()->user()->created_at)
                            <p class="text-muted col-12 fs-8">Data Belum Pernah Diperbarui</p>
                        @else
                            <p class="text-muted col-12 fs-8">Data Terakhir Diperbarui {{  \Carbon\Carbon::parse(auth()->user()->updated_at)->locale('id')->diffForHumans()  }}</p>
                        @endif
                        <form>
                            <div class="mb-3">
                                <label for="name-user" class="col-form-label">Nama</label>
                                <input type="text" class="form-control" id="name-user" name="name" placeholder="Ketik Nama" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="username-user" class="col-form-label">Username</label>
                                <input type="text" class="form-control" id="username-user" name="username" placeholder="Ketik Username" value="{{ auth()->user()->username }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_wa-user" class="col-form-label">No. Telpon</label>
                                <input type="text" class="form-control" id="no_wa-user" name="no_wa" placeholder="Ketik No. Telpon" value="{{ auth()->user()->no_wa }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat-user" class="col-form-label">Alamat</label>
                                <textarea class="form-control" id="alamat-user" name="alamat" rows="3" placeholder="Ketikan Alamat" required>{{ auth()->user()->alamat }}</textarea>
                            </div>
                            <div class="mb-3">
                                {{-- <label for="email-user" class="col-form-label"></label> --}}
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary">Perbarui Data</button>
                    </div>
                </div>
                </div>
                
            </div>

            <!-- Modal Ganti Password -->
            <div class="modal fade" id="myModalPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5 me-2 ">Ganti Password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form-change-password">
                                @csrf
                                <div class="mb-3">
                                    <label for="old-password-user" class="col-form-label">Password Lama</label>
                                    <input type="password" class="form-control" id="old-password-user" name="old_password" placeholder="Ketik Password Lama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new-password-user" class="col-form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="new-password-user" name="new_password" placeholder="Ketik Password Baru" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm-password-user" class="col-form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="confirm-password-user" name="confirm_password" placeholder="Ketik Password Baru" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="changePassword()" class="btn btn-sm btn-primary">Perbarui Password</button>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
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

    <script>

        function changePassword() {
            $('#form-change-password').submit();
        }

        $('#form-change-password').on('submit', function (e) {
            e.preventDefault();

            let formData = {
                old_password: $('#old-password-user').val(),
                new_password: $('#new-password-user').val(),
                confirm_password: $('#confirm-password-user').val(),
            };

            $.ajax({
                url: '{{ route('akun.change-password') }}', // Endpoint sesuai route Laravel
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val() // CSRF Token
                },
                success: function (response) {
                    alert(response.message); // Notifikasi sukses
                    $('#form-change-password')[0].reset(); // Reset form
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        $.each(errors, function (key, value) {
                            errorMessages += `${value}\n`;
                        });

                        alert('Gagal: \n' + errorMessages);
                    } else {
                        alert('Terjadi kesalahan, coba lagi nanti.');
                    }
                }
            });
        });
    </script>



</body>

</html>
