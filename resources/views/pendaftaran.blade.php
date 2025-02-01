@extends('layout')
@section('title', 'Pendaftaran Pasien')


@section('content')
    <div class="container-fluid mt-3">

        <div class="card shadow mt-3">
            <div class="card-body text-start p-1">
                <h4 class="card-title fw-bold mb-3 text-center">Pendaftaran Pasien</h4>
                <hr>
                {{-- <div class="card mb-3" style="outline: 3px dashed rgb(165, 165, 0); border-radius: 10px;">
                    <div class="card-body text-dark d-flex align-items-center" style="background-color: rgb(226, 226, 114);">
                        <i class="bi bi-exclamation-circle-fill me-2" style="font-size: 1.5rem;"></i>
                        <p class="mb-0">
                            Isian yang bertanda <span class="text-danger">*</span> wajib diisi
                        </p>
                    </div>
                </div> --}}

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title fw-bold">Data Pasien</h5>
                    </div>
                    <div class="card-body text-start overflow-auto">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th class="text-start" width="20%">Nama Pasien</th>
                                    <td class="text-start">: {{ auth()->user()->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">Alamat</th>
                                    <td class="text-start">: {{ auth()->user()->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-start">No. Telepon</th>
                                    <td class="text-start">: {{ auth()->user()->no_wa ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title fw-bold">Pendaftaran</h5>
                    </div>
                    <div class="card-body text-start">
                        <form class="needs-validation" novalidate="" method="POST" id="form-pendaftaran">
                            @csrf
                            <div class="mb-3 row">
                                <label for="nama_pasien" class="col-sm-2 col-form-label">Nama Pasien <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Ketikan Nama" value="{{ auth()->user()->name ?? '' }}" required>
                                    <div class="invalid-feedback">
                                        Nama harus diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat Pasien <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Ketikan Alamat" required>{{ auth()->user()->alamat ?? '' }}</textarea>
                                    <div class="invalid-feedback">
                                        Alamat harus diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="no_wa" class="col-sm-2 col-form-label">Nomor WA yang dapat dihubungi <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="no_wa" name="no_wa" placeholder="Ketikan Nomor WA" value="{{ auth()->user()->no_wa ?? '' }}" required>
                                    <div class="invalid-feedback">
                                        Nomor WA harus diisi dan minimal 11 digit!
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
                                <label for="rencana_pemeriksaan" class="col-sm-2 col-form-label">Rencana Pemeriksaan <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="rencana_pemeriksaan" name="rencana_pemeriksaan" placeholder="Pilih Tanggal Rencana Pemeriksaan" required>
                                    <div class="invalid-feedback">
                                        Nama harus diisi!
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

                            <div class="table-responsive d-none mt-3" id="pasien_table_section">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Pasien</th>
                                            <th>Keluhan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pasien_table_body">
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" id="btn-submit-pendaftaran" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#rencana_pemeriksaan').flatpickr({
                enableTime: false,
                dateFormat: "d-m-Y",
            });
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

            Swal.fire({
                title: 'Mohon tunggu...',
                html: 'Sedang memproses data.', // Teks tambahan (opsional)
                allowOutsideClick: false, // Mencegah klik di luar untuk menutup dialog
                didOpen: () => {
                    Swal.showLoading(); // Menampilkan animasi loading
                }
            });

            $('#btn-submit-pendaftaran').prop('disabled', true);

            // Jika form tidak valid, hentikan pengiriman data
            if (!this.checkValidity()) {
                Swal.close();
                $('#btn-submit-pendaftaran').prop('disabled', false);
                return;
            }

            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('pasien.pendaftaran.insert') }}",
                method: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.close();
                    $('#btn-submit-pendaftaran').prop('disabled', false);
                    if (response.success == true) {
                        Swal.fire({
                            title: '<h2>Berhasil!</h2>',
                            text: 'Pendaftaran berhasil',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ url('/pasien/pendaftaran/riwayat') }}";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: '<h2>Opss!</h2><br><h2>Pendaftaran gagal</h2>',
                            text: response.message,
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    }

                }, error : function(response) {
                    Swal.close();
                    $('#btn-submit-pendaftaran').prop('disabled', false);
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const pasienLainSection = document.getElementById('pasien_lain');
        const pasienTableSection = document.getElementById('pasien_table_section');
        const pasienTableBody = document.getElementById('pasien_table_body');
        const jumlahPasienInput = document.getElementById('jumlah_pasien_lain');

        // Event listener for radio buttons
        document.querySelectorAll('input[name="is_sendiri"]').forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'false') {
                    pasienLainSection.classList.remove('d-none');
                } else {
                    pasienLainSection.classList.add('d-none');
                    pasienTableSection.classList.add('d-none');
                    pasienTableBody.innerHTML = ''; // Clear table
                }
            });
        });

        // Event listener for jumlah pasien input
        jumlahPasienInput.addEventListener('input', function () {
            const jumlahPasien = parseInt(this.value, 10);
            
            if (isNaN(jumlahPasien) || jumlahPasien <= 0) {
                pasienTableSection.classList.add('d-none');
                pasienTableBody.innerHTML = ''; // Clear table
                return;
            }

            // Show table section
            pasienTableSection.classList.remove('d-none');
            pasienTableBody.innerHTML = ''; // Clear table for new input

            // Create rows dynamically
            for (let i = 1; i <= jumlahPasien; i++) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${i}</td>
                    <td>
                        <input type="text" class="form-control" name="nama_pasien_lain[]" placeholder="Nama Pasien ${i}" required>
                    </td>
                    <td>
                        <textarea class="form-control" name="keluhan_pasien_lain[]" placeholder="Keluhan ${i}" rows="2" required></textarea>
                    </td>
                `;
                pasienTableBody.appendChild(row);
            }
        });
    });

    </script>
@endsection




    
