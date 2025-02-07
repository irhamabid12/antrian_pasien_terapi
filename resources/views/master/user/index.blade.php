@extends('layout')
@section('title', 'Master | Pondok Pengobatan Gus Arya')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title fw-bold">Data User Admin</h5>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary btn-sm bg-gradient" data-bs-toggle="modal" data-bs-target="#modalNewAdmin">
                        <i class="bi bi-plus-circle"></i> Tambah User
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-user">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Tanggal di Tambahkan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalNewAdmin">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 me-2 ">Tambah User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-register-admin">
                            @csrf
                            <div class="mb-3">
                                <label for="name-user" class="col-form-label">Nama</label>
                                <input type="text" class="form-control" id="name-user" name="name" placeholder="Ketik Nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="username-user" class="col-form-label">Username</label>
                                <input type="text" class="form-control" id="username-user" name="username" placeholder="Ketik Username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password-user" class="col-form-label">Password</label>
                                <input type="password" class="form-control" id="password-user" name="password" placeholder="Ketik Password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm-password-user" class="col-form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="confirm-password-user" name="confirm_password" placeholder="Ketik Password" required>
                            </div>
                            <div class="mb-3">
                                <label for="role-user" class="col-form-label">Role</label>
                                <select class="form-select" name="role" id="role-user" required>
                                    <option selected disabled value="">--- Pilih Role ---</option>
                                    <option value="admin">Admin</option>
                                    <option value="superadmin">Super Admin</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-primary" onclick="registerAdmin()">Tambah User</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            loadTable();
        });

        function loadTable() {
            var table = $('#table-user').DataTable({
                processing: false,
                serverSide: false,
                destroy: true,
                // dom: '<"row"<"col-sm-12 col-md-12"l>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                dom: '<"row"rt><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"p>>',
                responsive: true,
                ajax: {
                    url: "{{ route('admin.master.load-table') }}",
                    method: 'GET',
                    data: function(d) {
                        d.role = 'admin';
                    }, success: function(data) {
                        // console.log(data);
                        var data = data.map(function(data, index) {
                            return [
                                index + 1,
                                data.name ?? '-',
                                data.username ?? '-',
                                data.role ?? '-',
                                data.tanggaldaftar ?? '-',
                                '<button onclick="deleteUser(' + data.id + ')" type="button" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>'
                            ];
                        });

                        // Mengisi DataTable dengan data yang baru
                        table.clear();
                        table.rows.add(data);
                        table.draw();
                    }
                },
            });
        }

        function registerAdmin() {
            $('#form-register-admin').submit();
        }

        function deleteUser(id) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Apakah anda yakin ingin menghapus data ini?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.master.delete-user-admin') }}",
                        method: 'get',
                        data: {
                            id: id
                        },
                        success: function (response) {
                            if (response.success === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                });
                            }
                            loadTable();
                        },
                        error: function (xhr) {
                            console.log(xhr.responseJSON.errors);
                        }
                    });
                }
            });
        }

        $('#form-register-admin').on('submit', function (e) {
            e.preventDefault();

            var myForm = this;
            var formData = new FormData(myForm);

            $.ajax({
                url: "{{ route('admin.master.add-new-admin') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false, 
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val() // CSRF Token
                },
                success: function (response) {
                    if (response.success === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                        });
                    }
                    $('#form-register-admin')[0].reset(); // Reset form
                    $('#modalNewAdmin').modal('hide');
                    loadTable();
                },
                error: function (xhr) {
                    console.log(xhr.responseJSON.errors);
                    
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        $.each(errors, function (key, value) {
                            errorMessages += `${value}<br>`;
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            html: errorMessages,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan, silahkan coba lagi.',
                        });
                    }
                }
            });
        });
    </script>
@endsection