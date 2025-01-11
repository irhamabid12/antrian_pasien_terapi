@extends('layout2')

@section('title', 'Login')
@section('content')
<div class="container">

    <div class="container h-100">
        <div class="d-flex justify-content-center align-items-center vh-100 my-5">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-12 col-md-6 my-5 text-center">
                                <h4 class="fw-bold mb-4">Pondok Pengobatan Gus Arya</h4>
                                <img src="{{ asset('assets\images\logo.jpg') }}" alt="logo" width="150" height="150">
                                <p class="card-text mt-3">
                                    <strong>Alamat:</strong> <br>Desa krompeng RT 03/02, Kecamatan Talun, kabupaten Pekalongan.<br>
                                    <strong>Informasi/Konsultasi:</strong><br> 0856-7223-499<br>
                                </p>
                            </div>
                            <div class="col-12 col-md-6 my-5">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
                                        <form method="POST" class="needs-validation" novalidate="" autocomplete="off" id="form-login-admin" action="{{ route('action-login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="mb-2 text-muted" for="email">Username</label>
                                                <input id="username" type="text" class="form-control" name="username" value="" required>
                                                <div class="invalid-feedback">
                                                    Username harus diisi!
                                                </div>
                                            </div>
                
                                            <div class="mb-3">
                                                <div class="mb-2 w-100">
                                                    <label class="text-muted" for="password">Password</label>
                                                    {{-- <a href="forgot.html" class="float-end">
                                                        Lupa Password?
                                                    </a> --}}
                                                </div>
                                                <input id="password" type="password" class="form-control" name="password" required>
                                                <div class="invalid-feedback">
                                                    Password harus diisi!
                                                </div>
                                            </div>
                
                                            <div class="d-flex align-items-center">
                                                <button type="submit" class="btn btn-primary ms-auto">
                                                    Login
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-3 border-0">
                        <div class="text-center fw-bold">
                            Belum punya akun? <a href="{{ url('registrasi/index') }}" class="text-primary">Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })();
</script>
@endsection