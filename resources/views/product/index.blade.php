@extends('layout')
@section('title', 'Master | Pondok Pengobatan Gus Arya')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title fw-bold">Data Product</h5>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary btn-sm bg-gradient" data-bs-toggle="modal" data-bs-target="#modalAddProduct">
                        <i class="bi bi-plus-circle"></i> Tambah Product
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-product">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Product</th>
                                <th>Harga Beli/Modal</th>
                                <th>Harga Jual</th>
                                <th>Jumlah Stok</th>
                                <th>Tanggal Entri</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header">
                <h5 class="card-title fw-bold">Checkout Product</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <select class="form-select" name="nama_product" id="nama_product_checkout" required>
                            <option selected disabled value="">Pilih Nama Product</option>
                            @foreach ($product as $item)
                                <option value="{{ $item->product_id }}" data-price="{{ $item->harga_jual }}">{{ $item->nama_product }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <div class="input-group">
                            <input type="number" min="1" class="form-control" id="jumlah_checkout" name="jumlah_checkout" placeholder="Ketik Jumlah" required>
                            <span class="input-group-text">pcs</span>
                        </div>
                    </div>

                    <div class="col">
                        <h4>Total : <span id="total_checkout">0</span></h4>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="button" onclick="checkoutProduct()" class="btn btn-primary btn-sm bg-gradient" id="btn-checkout">
                    <i class="bi bi-bag-check"></i> Checkout
                </button>
            </div>
        </div>

        <div class="modal fade" id="modalAddProduct">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 me-2 ">Tambah User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-new-product">
                            @csrf
                            <input type="hidden" name="product_id" id="product_id">
                            <div class="row">
                                <div class="col">
                                    <label for="nama_product" class="col-form-label">Nama Product</label>
                                    <input type="text" class="form-control" id="nama_product" name="nama_product" placeholder="Ketik Nama Produk" required>
                                </div>
                                <div class="col">
                                    <label for="harga_beli" class="col-form-label">Harga Beli</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp. </span>
                                        <input type="text" class="form-control" id="harga_beli" name="harga_beli" placeholder="Ketik Harga Beli" oninput="formatRupiah(this)" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="harga_jual" class="col-form-label">Harga Jual</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp. </span>
                                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" placeholder="Ketik Harga Jual" oninput="formatRupiah(this)" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="jumlah_stok" class="col-form-label">Jumlah Stok</label>
                                    <div class="input-group">
                                        <input type="number" min="1" class="form-control" id="jumlah_stok" name="jumlah_stok" placeholder="Ketik Jumlah Stok" required>
                                        <span class="input-group-text">pcs</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addProduct()">Simpan</button>
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
            var table = $('#table-product').DataTable({
                processing: false,
                serverSide: false,
                destroy: true,
                // dom: '<"row"<"col-sm-12 col-md-12"l>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                dom: '<"row"rt><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"p>>',
                responsive: true,
                ajax: {
                    url: "{{ route('admin.product.load-table') }}",
                    method: 'GET',
                    data: function(d) {
                        d.role = 'admin';
                    }, success: function(data) {
                        var data = data.map(function(data, index) {
                            return [
                                index + 1,
                                data.nama_product ?? '-',
                                data.harga_beli ? parseInt(data.harga_beli).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) : '-',
                                data.harga_jual ? parseInt(data.harga_jual).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) : '-',
                                (data.jumlah_stok ?? '-') + ' pcs',
                                data.tanggalentri ?? '-',
                                '<div class="btn-group" role="group">' +
                                '<button type="button" class="btn btn-info btn-sm" onclick="editProduct(' + data.product_id + ')"><i class="bi bi-pencil"></i> Edit</button>' +
                                '<button onclick="deleteProduct(' + data.product_id  + ')" type="button" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>' +
                                '</div>'
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

        function addProduct() {
            $('#form-new-product').submit();
        }

        function deleteProduct(product_id) {
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
                        url: "{{ route('admin.product.delete') }}",
                        method: 'get',
                        data: {
                            product_id: product_id
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

        $('#form-new-product').on('submit', function (e) {
            e.preventDefault();

            var myForm = this;
            var formData = new FormData(myForm);
            var harga_beli = $('#harga_beli').val() ? parseInt($('#harga_beli').val().replace(/[^0-9]/g, '')) : 0;
            var harga_jual = $('#harga_jual').val() ? parseInt($('#harga_jual').val().replace(/[^0-9]/g, '')) : 0;

            formData.append('harga_beli', harga_beli);
            formData.append('harga_jual', harga_jual);

            $.ajax({
                url: "{{ route('admin.product.insert') }}",
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
                    $('#form-new-product')[0].reset(); // Reset form
                    $('#modalAddProduct').modal('hide');
                    $('#product_id').val('');
                    loadTable();
                },
                error: function (xhr) {
                    // console.log(xhr.responseJSON.errors);
                    
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

        // Fungsi format rupiah
        function formatRupiah(element) {
            let inputValue = element.value;

            // Hanya izinkan angka (hapus semua karakter selain angka)
            let numberString = inputValue.replace(/[^0-9]/g, '');
            
            let split = numberString.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // Tambahkan titik jika ada ribuan
            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

            element.value = rupiah;
        }


        var price = 0;
        $('#nama_product_checkout').change(function() {
            var selectedOption = $(this).find('option:selected');
            price = selectedOption.data('price');
        });

        $('#jumlah_checkout').on('input', function () {
            var harga_jual = parseInt(price);

            var jumlah_checkout = parseInt($(this).val());
            var total = harga_jual * jumlah_checkout;
            $('#total_checkout').text(total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
        });

        function checkoutProduct() {
            var nama_product = $('#nama_product_checkout').val();
            var jumlah_checkout = $('#jumlah_checkout').val();

            $.ajax({
                url: '{{ route('admin.product.checkout') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nama_product: nama_product,
                    jumlah_checkout: jumlah_checkout
                },
                success: function (response) {
                    $('#nama_product_checkout').val('').trigger('change');
                    $('#jumlah_checkout').val('').trigger('input');

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
                    
                    let errorMessages = '';

                    // Cek jika response JSON memiliki 'errors' atau jika response adalah string error
                    if (xhr.status === 422) {
                        if (xhr.responseJSON.error) {
                            errorMessages = xhr.responseJSON.error
                        } else {
                            // Jika ada errors dalam response JSON
                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function (key, value) {
                                errorMessages += `${value}<br>`;
                            });
                        }

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
        }

        function editProduct(product_id) {
            $.ajax({
                url: '{{ route('admin.product.edit') }}',
                method: 'get',
                data: {
                    product_id: product_id
                },
                success: function (response) {
                    $('#modalAddProduct').modal('show');
                    $('#form-new-product #product_id').val(response.product_id);
                    $('#form-new-product #nama_product').val(response.nama_product);
                    $('#form-new-product #harga_beli').val(response.harga_beli).trigger('input');
                    $('#form-new-product #harga_jual').val(response.harga_jual).trigger('input');
                    $('#form-new-product #jumlah_stok').val(response.jumlah_stok);
                },
                error: function (xhr, status, errors) {                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON.errors,
                    });
                }
            });
        }
    </script>
@endsection