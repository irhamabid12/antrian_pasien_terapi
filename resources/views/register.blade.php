@extends('layout2')
@section('title', 'Daftar Akun Admin')
@section('content')
<div class="container mt-5">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body text-start p-5">
                <div class="col-md-12 text-center mb-4">
                    <h4 class="fw-bold mb-4">Daftar Akun</h4>
                </div>

                <form class="row g-3 needs-validation" id="form-register-admin" method="POST" novalidate="" autocomplete="off">
                    @csrf
                    <div class="col-md-12">
                        <label for="name" class="form-label fw-bold mt-3">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ketik Nama Pertama" required>
                        <div class="invalid-feedback">
                            Name Depan harus diisi
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="username" class="form-label fw-bold mt-3">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Ketik Username" required>
                        <div class="invalid-feedback">
                            Username harus diisi
                        </div>
                    </div>                        
                    <div class="col-12">
                        <label for="password" class="form-label fw-bold mt-3">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ketik Password" required>
                        <div class="invalid-feedback">
                            Password harus diisi
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="confirm-password" class="form-label fw-bold mt-3">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm-password " name="confirm_password" placeholder="Ketik Password" required>
                        <div class="invalid-feedback">
                            Konfirmasi Password harus diisi
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" id="btn-submit-register" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    Sudah punya akun? <a href="admin/login/index" class="text-dark">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {

                    var password = form.querySelector('#password').value;
                    var passwordConfirmation = form.querySelector('#confirm-password').value;

                    if (!form.checkValidity() || password !== passwordConfirmation) {
                        event.preventDefault()
                        event.stopPropagation()

                        if (password !== passwordConfirmation) {
                            swal("Error", "Passwords do not match", "error");
                        }
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

    $('#form-register-admin').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('admin.registrasi.insert') }}",
            method: "POST",
            data: formData,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success == true) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Pasien berhasil ditambahkan!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                }
            }, error : function(response) {
                console.log(response);
            }
        });
    });
</script>
@endsection