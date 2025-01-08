@extends('layout')
@section('title', 'Pendaftaran Pasien')


@section('content')
    <div class="container mt-3">

        <div class="card shadow mt-3">
            <div class="card-body text-start p-5">
                <h3 class="card-title fw-bold mb-3 text-center">Pendaftaran Pasien</h3>
                <div class="card mb-3" style="outline: 3px dashed rgb(165, 165, 0); border-radius: 10px;">
                    <div class="card-body text-dark d-flex align-items-center" style="background-color: rgb(226, 226, 114);">
                        <i class="bi bi-exclamation-circle-fill me-2" style="font-size: 1.5rem;"></i>
                        <p class="mb-0">
                            Isian yang bertanda <span class="text-danger">*</span> wajib diisi
                        </p>
                    </div>
                </div>
                <form class="needs-validation" novalidate="" method="POST" id="form-pendaftaran">
                    @csrf
                    <div class="mb-3 row">
                        <label for="nama_pasien" class="col-sm-2 col-form-label">Nama Pasien <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Ketikan Nama" required>
                            <div class="invalid-feedback">
                                Nama harus diisi!
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="keluhan" class="col-sm-2 col-form-label">Keluhan Pasien <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="3" placeholder="Ketikan Keluhan" required></textarea>
                            <div class="invalid-feedback">
                                Keluhan harus diisi!
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat Pasien <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Ketikan Alamat" required></textarea>
                            <div class="invalid-feedback">
                                Alamat harus diisi!
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Status Pasien <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_pasien" id="status_pasien1" value="Baru">
                                <label class="form-check-label" for="status_pasien1">
                                    Baru
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_pasien" id="status_pasien2" value="Kontrol">
                                <label class="form-check-label" for="status_pasien2">
                                    Kontrol
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_wa" class="col-sm-2 col-form-label">Nomor WA yang dapat dihubungi <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="no_wa" name="no_wa" placeholder="Ketikan Nomor WA" required>
                          <div class="invalid-feedback">
                            Nomor WA harus diisi dan minimal 11 digit!
                          </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Pasien Sendiri <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_sendiri" id="is_sendiri1" value="true">
                                <label class="form-check-label" for="is_sendiri1">
                                    Ya
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_sendiri" id="is_sendiri2" value="false">
                                <label class="form-check-label" for="is_sendiri2">
                                    Tidak
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row d-none" id="pasien_lain">
                        <label for="jumlah_pasien_lain" class="col-sm-2 col-form-label">Jumlah Pasien Lain</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="jumlah_pasien_lain" name="jumlah_pasien_lain" placeholder="Ketikan Jumlah Pasien Lain">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('input[name="is_sendiri"]').on('change', function() {
            if (this.value == 'true') {
                $('#pasien_lain').removeClass('d-none');
            } else {
                $('#pasien_lain').addClass('d-none');
            }
        });

        (function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        // Validasi radio button untuk status_pasien
                        var statusPasienSelected = document.querySelector('input[name="status_pasien"]:checked');
                        if (!statusPasienSelected) {
                            var statusPasienGroup = document.querySelector('input[name="status_pasien"]').closest('.col-sm-10');
                            statusPasienGroup.classList.add('is-invalid');
                            statusPasienGroup.insertAdjacentHTML('beforeend', '<div class="invalid-feedback d-block">Status pasien harus dipilih!</div>');
                        }

                        // Validasi radio button untuk is_sendiri
                        var isSendiriSelected = document.querySelector('input[name="is_sendiri"]:checked');
                        if (!isSendiriSelected) {
                            var isSendiriGroup = document.querySelector('input[name="is_sendiri"]').closest('.col-sm-10');
                            isSendiriGroup.classList.add('is-invalid');
                            isSendiriGroup.insertAdjacentHTML('beforeend', '<div class="invalid-feedback d-block">Harap pilih apakah pasien adalah diri sendiri atau tidak!</div>');
                        }

                        // Validasi nomor WA harus minimal 12 digit
                        var noWaInput = document.getElementById('no_wa');
                        if (noWaInput.value.length < 12) {
                            noWaInput.setCustomValidity('Nomor WA harus minimal 12 digit.');
                        } else {
                            noWaInput.setCustomValidity('');
                        }
                        
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                });

                // Tambahkan event listener untuk menghapus pesan error pada radio button saat dipilih
                document.querySelectorAll('input[name="status_pasien"]').forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        var statusPasienGroup = radio.closest('.col-sm-10');
                        statusPasienGroup.classList.remove('is-invalid');
                        var feedback = statusPasienGroup.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.remove();
                        }
                    });
                });

                document.querySelectorAll('input[name="is_sendiri"]').forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        var isSendiriGroup = radio.closest('.col-sm-10');
                        isSendiriGroup.classList.remove('is-invalid');
                        var feedback = isSendiriGroup.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.remove();
                        }
                    });
                });
        })();

        $('#form-pendaftaran').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('pendaftaran.insert') }}",
                method: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Pasien berhasil didaftarkan!',
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




    
