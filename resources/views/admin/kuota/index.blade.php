@extends('layout2')
@section('title', 'Kuota Pasien dan Jadwal Operasional')  

@section('content')
    @include('admin.navbar')
   
    <div class="container mt-3">
        <div class="card shadow mt-3 ">
            <div class="card-header">
                <h5 class="card-title fw-bold">Pengaturan Jadwal Operasional</h5>
            </div>
            <div class="card-body text-center">
                {{-- <div class="table-responsive">
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
                </div> --}}

                 <!-- Input Rentang Tanggal -->
                <div class="row mb-4">
                    <div class="col-md-4 text-start my-3">
                        <label for="start_date" class="form-label fw-bold">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" required>
                    </div>
                    <div class="col-md-4 text-start my-3">
                        <label for="end_date" class="form-label fw-bold">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end my-3">
                        <button id="generate_schedule" class="btn btn-primary w-100">Buat Rencana Jadwal</button>
                    </div>
                </div>

                <!-- Daftar Hari (Akan Ditampilkan Setelah Klik "Buat Rencana Jadwal") -->
                <div id="schedule_container" class="d-none">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Kuota Pasien</th>
                                <th>Operasional</th>
                            </tr>
                        </thead>
                        <tbody id="schedule_table_body">
                            <!-- Data akan di-generate oleh JavaScript -->
                        </tbody>
                    </table>

                    <!-- Tombol Simpan -->
                    <div class="d-flex justify-content-end mt-3">
                        <button id="save_schedule" class="btn btn-success">Simpan Jadwal</button>
                    </div>
            </div>
        </div>
    </div>

    <div class="card shadow mt-3 ">
        <div class="card-header">
            <h5 class="card-title fw-bold">Jadwal Operasional</h5>
        </div>
        <div class="card-body" style="overflow: auto">
           <table class="table table-bordered table-striped text-center">
               <thead>
                   <tr>
                        <th>Tanggal</th>
                        <th>Kuota Pasien</th>
                        <th>Operasional</th>
                        <th>Aksi</th>
                   </tr>
               </thead>
               <tbody>
                    @if ($data->isEmpty() === false)
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ !empty($item->tanggal) ? \Carbon\Carbon::parse($item->tanggal)->isoFormat('dddd, D MMMM Y') : '-' }}</td>
                            <td>{{ $item->jumlah_kuota }}</td>
                            <td>{{ $item->operasional ? 'Buka' : 'Tutup' }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteSchedule({{ $item->jadwal_id }})" ><i class="fa fa-trash"></i> Hapus</button>
                            </td>
                        </tr>
                        
                        @endforeach
                    @else
                        <tr><td colspan="4" class="text-center">Tidak ada data jadwal</td></tr>
                    @endif
               </tbody>
           </table>
        </div>
    </div>

    <script>
        document.getElementById('save_schedule').addEventListener('click', function () {
            const rows = document.querySelectorAll('#schedule_table_body tr');
            const scheduleData = [];

            rows.forEach(row => {
                const date = row.cells[0].innerText;
                const day = row.cells[1].innerText;
                const quota = row.querySelector('input[type="number"]').value;
                const operational = row.querySelector('input[type="checkbox"]').checked ? 1 : 0;

                scheduleData.push({ date, day, quota, operational });
            });

            console.log(scheduleData); // Kirim data ke server dengan AJAX

            // Contoh AJAX untuk menyimpan data
            $.ajax({
                url: '{{ route('admin.kuota.simpan-jadwal') }}',
                method: 'POST',
                data: { 
                    schedule: scheduleData,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Jadwal berhasil disimpan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        })
                        location.reload();
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menyimpan jadwal.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                }
            });
        });

    </script>

    <script>
        document.getElementById('generate_schedule').addEventListener('click', function () {
            const startDateInput = document.getElementById('start_date').value;
            const endDateInput = document.getElementById('end_date').value;

            if (!startDateInput || !endDateInput) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silakan pilih rentang tanggal terlebih dahulu.',
                });
                
                return;
            }

            const startDate = new Date(startDateInput);
            const endDate = new Date(endDateInput);

            if (startDate > endDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tanggal mulai harus lebih awal dari tanggal selesai.',
                });
                return;
            }

            const scheduleContainer = document.getElementById('schedule_container');
            const scheduleTableBody = document.getElementById('schedule_table_body');

            // Kosongkan tabel sebelumnya jika ada
            scheduleTableBody.innerHTML = '';

            // Generate daftar hari dalam rentang tanggal
            for (let d = startDate; d <= endDate; d.setDate(d.getDate() + 1)) {
                const dateString = d.toISOString().split('T')[0]; // Format: YYYY-MM-DD
                const dayName = new Intl.DateTimeFormat('id-ID', { weekday: 'long' }).format(d); // Nama hari

                // Tambahkan baris ke tabel
                scheduleTableBody.innerHTML += `
                    <tr>
                        <td>${dateString}</td>
                        <td>${dayName}</td>
                        <td>
                            <input type="number" class="form-control" name="kuota[${dateString}]" placeholder="Kuota" min="0" required>
                        </td>
                        <td class="text-center">
                            <input type="checkbox" name="operasional[${dateString}]" value="1" checked>
                        </td>
                    </tr>
                `;
            }

            // Tampilkan tabel
            scheduleContainer.classList.remove('d-none');
        });

        function deleteSchedule(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus jadwal ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.kuota.delete') }}',
                        method: 'get',
                        data: { 
                            jadwal_id: id 
                        },
                        success: function (response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert('Gagal menghapus jadwal.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan.');
                        }
                    });
                }
            });
        }

    </script>

    
@endsection


    
