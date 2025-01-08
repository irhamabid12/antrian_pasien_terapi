@extends('layout2')
@section('title', 'Kuota Pasien dan Jadwal Operasional')  

@section('content')
    @include('admin.navbar')
   
    <div class="container mt-3">
        <div class="card shadow mt-3 ">
            <div class="card-header">
                <h5 class="card-title fw-bold">Pengaturan Kouta Pasien dan Jadwal Operasional</h5>
            </div>
            <div class="card-body text-center">
                <div class="table-responsive">
                    <form id="form-kuota" method="POST">
                        @csrf
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="20%">Hari</th>
                                    <th width="20%" class="text-center">Praktek Libur/Buka</th>
                                    <th>Kuota</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Senin -->
                                <tr class="text-center">
                                    <td>
                                        Senin
                                        <input type="hidden" name="hari1" value="1">
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switchSenin" name="switchSenin">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="kuotaSenin" name="kuotaSenin" placeholder="Kuota Pasien" aria-label="Kuota Pasien" aria-describedby="addonSenin">
                                            <span class="input-group-text" id="addonSenin">Pasien</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Selasa -->
                                <tr>
                                    <td>
                                        Selasa
                                        <input type="hidden" name="hari2" value="2">
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switchSelasa" name="switchSelasa">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="kuotaSelasa" name="kuotaSelasa" placeholder="Kuota Pasien" aria-label="Kuota Pasien" aria-describedby="addonSelasa">
                                            <span class="input-group-text" id="addonSelasa">Pasien</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Rabu -->
                                <tr>
                                    <td>
                                        Rabu
                                        <input type="hidden" name="hari3" value="3">
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switchRabu" name="switchRabu">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="kuotaRabu" name="kuotaRabu" placeholder="Kuota Pasien" aria-label="Kuota Pasien" aria-describedby="addonRabu">
                                            <span class="input-group-text" id="addonRabu">Pasien</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Kamis -->
                                <tr>
                                    <td>
                                        Kamis
                                        <input type="hidden" name="hari4" value="4">
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switchKamis" name="switchKamis">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="kuotaKamis" name="kuotaKamis" placeholder="Kuota Pasien" aria-label="Kuota Pasien" aria-describedby="addonKamis">
                                            <span class="input-group-text" id="addonKamis">Pasien</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Jumat -->
                                <tr>
                                    <td>
                                        Jumat
                                        <input type="hidden" name="hari5" value="5">
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switchJumat" name="switchJumat">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="kuotaJumat" name="kuotaJumat" placeholder="Kuota Pasien" aria-label="Kuota Pasien" aria-describedby="addonJumat">
                                            <span class="input-group-text" id="addonJumat">Pasien</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Sabtu -->
                                <tr>
                                    <td>
                                        Sabtu
                                        <input type="hidden" name="hari6" value="6">
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switchSabtu" name="switchSabtu">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="kuotaSabtu" name="kuotaSabtu" placeholder="Kuota Pasien" aria-label="Kuota Pasien" aria-describedby="addonSabtu">
                                            <span class="input-group-text" id="addonSabtu">Pasien</span>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Minggu -->
                                <tr>
                                    <td>
                                        Minggu
                                        <input type="hidden" name="hari7" value="7">
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switchMinggu" name="switchMinggu">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="kuotaMinggu" name="kuotaMinggu" placeholder="Kuota Pasien" aria-label="Kuota Pasien" aria-describedby="addonMinggu">
                                            <span class="input-group-text" id="addonMinggu">Pasien</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Icon Bootstrap dengan Opacity -->
        </div>
    </div>

    <script>
         $('#form-kuota').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('admin.kuota.update-kuota') }}",
                method: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            title: '<h2>Berhasil!</h2>',
                            text: 'Data berhasil diubah!',
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


    
