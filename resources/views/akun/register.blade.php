@extends('layout2')
@section('title', 'Daftar Akun')
@section('content')
<div class="container mt-5 mb-5">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body text-start p-5">
                <div class="col-md-12 text-center mb-4">
                    <h4 class="fw-bold mb-4">Daftar Akun</h4>
                </div>

                <form class="row g-3 needs-validation" id="form-registrasi-akun" method="POST" novalidate="" autocomplete="off">
                    @csrf
                    <div class="col-md-12">
                        <label for="name-pasien" class="form-label fw-bold mt-3">Nama Pasien <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name-pasien" name="name" placeholder="Ketik Nama Pasien" required>
                        <div class="invalid-feedback">
                            Name Depan harus diisi
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="username" class="form-label fw-bold mt-3">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Ketik Username Contoh: Tukiman1234" required>
                        <div class="invalid-feedback">
                            Username harus diisi
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label for="alamat" class="form-label fw-bold mt-3">Alamat Pasien <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Ketikan Alamat" required></textarea>
                        <div class="invalid-feedback">
                            Alamat harus diisi!
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="no_wa" class="form-label fw-bold mt-3">Nomor WA yang dapat dihubungi <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="no_wa" name="no_wa" placeholder="Ketikan Nomor WA" required>
                        <div class="invalid-feedback">
                          Nomor WA harus diisi dan minimal 11 digit!
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="password" class="form-label fw-bold mt-3">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ketik Password" required>
                        <div class="invalid-feedback">
                            Password harus diisi
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="confirm-password" class="form-label fw-bold mt-3">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm_password" placeholder="Ketik Password" required>
                        <div class="invalid-feedback">
                            Konfirmasi Password harus diisi
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" id="btn-submit-register" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="text-center fw-bold">
                    Sudah punya akun? <a href="{{ url('/login') }}" class="text-primary">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function () {
        'use strict';

        // Fetch the form
        var form = document.getElementById('form-registrasi-akun');

        // Add submit event listener to the form
        form.addEventListener('submit', function (event) {
            Swal.fire({
                title: 'Mohon tunggu...',
                html: 'Sedang memproses data.', // Teks tambahan (opsional)
                allowOutsideClick: false, // Mencegah klik di luar untuk menutup dialog
                didOpen: () => {
                    Swal.showLoading(); // Menampilkan animasi loading
                }
            });

            var password = $('#form-registrasi-akun #password').val();
            var passwordConfirmation = $('#form-registrasi-akun #confirm-password').val();
                        
            // Perform custom validation
            if (!form.checkValidity() || password !== passwordConfirmation) {
                event.preventDefault();
                event.stopPropagation();

                Swal.close();
                // Show error if passwords do not match
                if (password !== passwordConfirmation) {
                    Swal.fire({
                        title: 'Oops...',
                        text: 'Password dan Konfirmasi Password tidak cocok! Silahkan coba lagi',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                }

                // Add Bootstrap validation styles
                form.classList.add('was-validated');
                return; // Stop further execution if validation fails
            }

            // If the form is valid, proceed with AJAX submission
            event.preventDefault();
            var formData = new FormData(form);

            $.ajax({
                url: "{{ route('registrasi.registrasiAkunPasien') }}",
                method: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.close();
                    if (response.success === true) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Registrasi berhasil!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ url('/login') }}";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Oops...',
                            text: response.message,
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (response) {
                    Swal.close();
                    console.error(response);
                }
            });
        });
    })();
</script>
@endsection