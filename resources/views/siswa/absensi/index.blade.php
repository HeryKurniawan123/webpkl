@extends('layout.main')

@section('content')
    <div class="container-fluid"><br>
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">

                {{-- Welcome Card --}}
                <div class="row">
                    <div class="col-lg-12 mb-3 order-0">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Selamat Datang di Sistem Absensi! 👋</h5>
                                        <p class="mb-4">Jangan lupa untuk melakukan absensi setiap hari. Klik tombol di
                                            bawah untuk absen masuk atau pulang.</p>
                                    </div>
                                </div>
                                <div class="col-sm-5 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="{{ asset('snet/assets/img/illustrations/man-with-laptop-light.png') }}"
                                            height="140" alt="Absensi Siswa"
                                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                            data-app-light-img="illustrations/man-with-laptop-light.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Absensi --}}
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Absensi Hari Ini</h5>
                                <small class="text-muted">Klik tombol untuk melakukan absensi</small>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <form method="POST" action="{{ route('absensi.masuk') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100 btn-lg">
                                                <i class="bi bi-clock me-2"></i>
                                                <div>
                                                    <strong>Absen Masuk</strong>
                                                    <br><small>Klik untuk absen masuk</small>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form method="POST" action="{{ route('absensi.pulang') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-warning w-100 btn-lg">
                                                <i class="bi bi-clock-history me-2"></i>
                                                <div>
                                                    <strong>Absen Pulang</strong>
                                                    <br><small>Klik untuk absen pulang</small>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Tombol Izin -->
                                <div class="row g-3 mt-3">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger w-100 btn-lg" data-bs-toggle="modal"
                                            data-bs-target="#modalIzin">
                                            <i class="bi bi-file-earmark-text me-2"></i>
                                            <div>
                                                <strong>Ajukan Izin</strong>
                                                <br><small>Klik untuk mengajukan izin PKL</small>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <!-- Modal Izin -->
                                <div class="modal fade" id="modalIzin" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('izin.store') }}">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Ajukan Izin PKL</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="tipe_izin">Tipe Izin</label>
                                                        <select name="tipe_izin" id="tipe_izin" class="form-control">
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Sakit">Sakit</option>
                                                            <option value="Izin">Izin</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggal" class="form-label">Tanggal</label>
                                                        <input type="date" class="form-control" name="tanggal" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alasan" class="form-label">Keterangan</label>
                                                        <textarea class="form-control" name="alasan" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Kirim Izin</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                {{-- Status Absensi Hari Ini --}}
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="alert alert-info d-none" id="statusAbsen">
                                            <h6 class="alert-heading mb-2">Status Absensi Hari Ini:</h6>
                                            <div id="statusContent">
                                                <div class="d-flex justify-content-between">
                                                    <span><strong>Masuk:</strong> <span id="jamMasuk">-</span></span>
                                                    <span><strong>Pulang:</strong> <span id="jamPulang">-</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Absensi --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Riwayat Absensi</h5>
                                <div class="d-flex gap-2">
                                    <input type="date" class="form-control form-control-sm" id="filterTanggal"
                                        onchange="filterAbsensi()">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetFilter()">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tanggal</th>
                                                <th>Jam Masuk</th>
                                                <th>Jam Pulang</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabelAbsensi">
                                            <tr id="emptyState">
                                                <td colspan="6" class="text-muted">
                                                    <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                                                    <br>Belum ada data absensi
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Statistik Absensi (Optional) --}}
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                                <h4 class="mt-2" id="totalHadir">0</h4>
                                <p class="text-muted mb-0">Total Hadir</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                                <h4 class="mt-2" id="totalTerlambat">0</h4>
                                <p class="text-muted mb-0">Total Terlambat</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-x-circle text-danger" style="font-size: 2rem;"></i>
                                <h4 class="mt-2" id="totalAbsen">0</h4>
                                <p class="text-muted mb-0">Total Tidak Hadir</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-percent text-info" style="font-size: 2rem;"></i>
                                <h4 class="mt-2" id="persentaseKehadiran">0%</h4>
                                <p class="text-muted mb-0">Persentase Kehadiran</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastNotification" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                <strong class="me-auto" id="toastTitle">Berhasil!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                Absensi berhasil dicatat
            </div>
        </div>
    </div>

    <script>
        // Data absensi (simulasi - dalam implementasi nyata akan menggunakan database)
        let dataAbsensi = [];
        let absensiHariIni = null;

        // Fungsi untuk mendapatkan tanggal hari ini
        function getTanggalHariIni() {
            return new Date().toLocaleDateString('id-ID');
        }

        // Fungsi untuk mendapatkan waktu saat ini
        function getWaktuSekarang() {
            return new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }

        // Fungsi untuk menampilkan toast notification
        function showToast(title, message, type = 'success') {
            const toast = document.getElementById('toastNotification');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');
            const toastIcon = toast.querySelector('.toast-header i');

            toastTitle.textContent = title;
            toastMessage.textContent = message;

            // Update icon dan warna berdasarkan type
            if (type === 'success') {
                toastIcon.className = 'bi bi-check-circle-fill text-success me-2';
            } else if (type === 'warning') {
                toastIcon.className = 'bi bi-exclamation-triangle-fill text-warning me-2';
            } else if (type === 'error') {
                toastIcon.className = 'bi bi-x-circle-fill text-danger me-2';
            }

            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        }


        // Fungsi untuk update status absensi hari ini
        function updateStatusAbsensi() {
            const statusDiv = document.getElementById('statusAbsen');
            const jamMasukSpan = document.getElementById('jamMasuk');
            const jamPulangSpan = document.getElementById('jamPulang');

            if (absensiHariIni) {
                statusDiv.classList.remove('d-none');
                jamMasukSpan.textContent = absensiHariIni.jamMasuk || '-';
                jamPulangSpan.textContent = absensiHariIni.jamPulang || '-';
            }
        }

        // Fungsi untuk update tabel absensi
        function updateTabelAbsensi() {
            const tbody = document.getElementById('tabelAbsensi');
            const emptyState = document.getElementById('emptyState');

            if (dataAbsensi.length === 0) {
                emptyState.style.display = '';
                return;
            }

            emptyState.style.display = 'none';

            let html = '';
            dataAbsensi.forEach((item, index) => {
                let badgeClass = 'bg-success';
                if (item.status === 'Terlambat') badgeClass = 'bg-warning';
                if (item.status === 'Tidak Hadir') badgeClass = 'bg-danger';

                html += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.tanggal}</td>
                <td><code>${item.jamMasuk || '-'}</code></td>
                <td><code>${item.jamPulang || '-'}</code></td>
                <td><span class="badge ${badgeClass}">${item.status}</span></td>
                <td>${item.keterangan}</td>
            </tr>
        `;
            });

            tbody.innerHTML = html;
        }

        // Fungsi untuk update statistik
        function updateStatistik() {
            const totalHadir = dataAbsensi.filter(item => item.status === 'Hadir').length;
            const totalTerlambat = dataAbsensi.filter(item => item.status === 'Terlambat').length;
            const totalAbsen = dataAbsensi.filter(item => item.status === 'Tidak Hadir').length;
            const totalData = dataAbsensi.length;
            const persentase = totalData > 0 ? Math.round(((totalHadir + totalTerlambat) / totalData) * 100) : 0;

            document.getElementById('totalHadir').textContent = totalHadir;
            document.getElementById('totalTerlambat').textContent = totalTerlambat;
            document.getElementById('totalAbsen').textContent = totalAbsen;
            document.getElementById('persentaseKehadiran').textContent = persentase + '%';
        }

        // Fungsi untuk filter absensi berdasarkan tanggal
        function filterAbsensi() {
            const filterTanggal = document.getElementById('filterTanggal').value;
            if (!filterTanggal) {
                updateTabelAbsensi();
                return;
            }

            const tanggalFilter = new Date(filterTanggal).toLocaleDateString('id-ID');
            const dataFiltered = dataAbsensi.filter(item => item.tanggal === tanggalFilter);

            const tbody = document.getElementById('tabelAbsensi');
            const emptyState = document.getElementById('emptyState');

            if (dataFiltered.length === 0) {
                tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-muted">
                    <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                    <br>Tidak ada data absensi pada tanggal ${tanggalFilter}
                </td>
            </tr>
        `;
                return;
            }

            let html = '';
            dataFiltered.forEach((item, index) => {
                let badgeClass = 'bg-success';
                if (item.status === 'Terlambat') badgeClass = 'bg-warning';
                if (item.status === 'Tidak Hadir') badgeClass = 'bg-danger';

                html += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.tanggal}</td>
                <td><code>${item.jamMasuk || '-'}</code></td>
                <td><code>${item.jamPulang || '-'}</code></td>
                <td><span class="badge ${badgeClass}">${item.status}</span></td>
                <td>${item.keterangan}</td>
            </tr>
        `;
            });

            tbody.innerHTML = html;
        }

        // Fungsi untuk reset filter
        function resetFilter() {
            document.getElementById('filterTanggal').value = '';
            updateTabelAbsensi();
        }

        // Cek apakah ada absensi hari ini saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalHariIni = getTanggalHariIni();
            absensiHariIni = dataAbsensi.find(item => item.tanggal === tanggalHariIni);

            updateStatusAbsensi();
            updateTabelAbsensi();
            updateStatistik();

            // Set tanggal hari ini sebagai default filter
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('filterTanggal').value = today;
        });
    </script>
@endsection

{{-- SweetAlert untuk notifikasi dari session --}}
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toastNotification');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');

            toastTitle.textContent = 'Berhasil!';
            toastMessage.textContent = "{{ session('success') }}";

            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toastNotification');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');
            const toastIcon = toast.querySelector('.toast-header i');

            toastTitle.textContent = 'Error!';
            toastMessage.textContent = "{{ session('error') }}";
            toastIcon.className = 'bi bi-x-circle-fill text-danger me-2';

            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        });
    </script>
@endif
