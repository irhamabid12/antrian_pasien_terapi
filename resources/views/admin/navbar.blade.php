<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid mx-3">
        <!-- Logo dan Nama Pondok -->
        <a class="navbar-brand d-flex align-items-center" href="{{url('/admin/beranda/index')}}">
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
                    <a class="nav-link" aria-current="page" href="{{url('/admin/beranda/index')}}"><i class="bi bi-house-door-fill"></i> Beranda</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{url('/admin/kuota/index')}}"><i class="bi bi-gear-fill"></i> Kuota Pasien dan Jadwal Operasional</a>
                </li> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear-fill"></i> Pengaturan
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('admin.kuota.index') }}">Kuota dan Jadwal Operasional</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-workspace"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="bi bi-box-arrow-in-right"></i> logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>