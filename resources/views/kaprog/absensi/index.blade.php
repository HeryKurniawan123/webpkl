@extends('layout.main')

@section('content')
    <div class="container-fluid">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Simple Header Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 bg-white shadow-sm">
                        <div class="card-body p-4">
                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                <div>
                                    <h4 class="mb-1 text-dark fw-bold">Dashboard PKL & Absensi</h4>
                                    <p class="text-secondary mb-0">Monitoring kehadiran dan data siswa PKL Per Jurusan</p>
                                </div>

                                <div class="d-flex gap-2 ms-auto">
                                    <button class="btn btn-warning border d-flex align-items-center gap-1"
                                        data-bs-toggle="modal" data-bs-target="#modalBelumDikonfirmasi">
                                        <i class="fas fa-user-clock"></i> Belum Dikonfirmasi
                                    </button>

                                    <button class="btn btn-danger border d-flex align-items-center gap-1"
                                        data-bs-toggle="modal" data-bs-target="#modalBelumAbsen">
                                        <i class="fas fa-user-slash"></i> Belum Absen
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview Cards -->
            <div class="row g-4 mb-5">
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-4 p-3 me-3">
                                    <i class="fas fa-users fa-2x text-dark"></i>
                                </div>
                                <div>
                                    <h3 class="mb-1 fw-bold text-dark">{{ $totalSiswaPKL }}</h3>
                                    <p class="text-secondary mb-0 small">Total Siswa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-4 p-3 me-3">
                                    <i class="fas fa-user-check fa-2x" style="color: #16a085;"></i>
                                </div>
                                <div>
                                    <h3 class="mb-1 fw-bold text-dark">{{ $hadirHariIni }}</h3>
                                    <p class="text-secondary mb-0 small">Hadir Hari Ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-4 p-3 me-3">
                                    <i class="fas fa-user-clock fa-2x" style="color: #f39c12;"></i>
                                </div>
                                <div>
                                    <h3 class="mb-1 fw-bold text-dark">{{ $belumDikonfirmasi }}</h3>
                                    <p class="text-secondary mb-0 small">Belum Dikonfirmasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-4 p-3 me-3">
                                    <i class="fas fa-user-times fa-2x" style="color: #e67e22;"></i>
                                </div>
                                <div>
                                    <h3 class="mb-1 fw-bold text-dark">{{ $tidakHadir }}</h3>
                                    <p class="text-secondary mb-0 small">Belum Absen</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-5">
                <!-- Grafik Kehadiran -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-semibold text-dark">Grafik Kehadiran</h5>
                                <div class="dropdown">
                                    <button id="chartFilterBtn" class="btn btn-sm btn-light border dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown">
                                        7 Hari Terakhir
                                    </button>
                                    <ul class="dropdown-menu shadow-sm">
                                        <li><a class="dropdown-item chart-filter" href="#" data-filter="today">Hari
                                                Ini</a></li>
                                        <li><a class="dropdown-item chart-filter" href="#" data-filter="7">7 Hari
                                                Terakhir</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <canvas id="attendanceChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Distribusi per Kelas -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-4">
                            <h5 class="mb-0 fw-semibold text-dark">Distribusi Kelas</h5>
                        </div>
                        <div class="card-body p-4">
                            <canvas id="majorChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analisis Kehadiran per Kelas -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-semibold text-dark">Analisis Kehadiran per Kelas</h5>
                                    <p class="text-secondary mb-0 small">Tingkat kehadiran siswa per kelas hari ini</p>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary" id="refreshAnalisis">
                                        <i class="bx bx-refresh"></i> Refresh
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if (count($kelasAnalisis) > 0)
                                <div class="row g-4">
                                    @foreach ($kelasAnalisis as $kelas)
                                        <div class="col-lg-2 col-md-4 col-6">
                                            <div class="text-center p-3 bg-light rounded-4 h-100 d-flex flex-column">
                                                <h6 class="mb-0 fw-semibold text-dark">{{ $kelas['kelas'] }}</h6>
                                                <div class="h4 mb-1 fw-bold mt-auto"
                                                    style="color: {{ $kelas['persentase'] >= 90 ? '#27ae60' : ($kelas['persentase'] >= 85 ? '#f39c12' : '#e74c3c') }};">
                                                    {{ $kelas['persentase'] }}%
                                                </div>
                                                <small class="text-secondary">
                                                    {{ $kelas['hadir_count'] ?? 0 }}/{{ $kelas['total_siswa'] }} siswa
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Tidak ada data kelas untuk ditampilkan.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Absensi per Kelas -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-semibold text-dark">Detail Absensi per Kelas</h5>
                                    <p class="text-secondary mb-0 small">Data kehadiran siswa per kelas hari ini</p>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary" id="refreshBtn">
                                        <i class="bx bx-refresh"></i> Refresh Data
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <!-- Tab untuk setiap kelas -->
                            <ul class="nav nav-tabs mb-4" id="kelasTabs" role="tablist">
                                @foreach ($detailAbsensiPerKelas as $index => $kelas)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                            id="kelas-{{ $index }}-tab" data-bs-toggle="tab"
                                            data-bs-target="#kelas-{{ $index }}" type="button" role="tab">
                                            {{ $kelas['kelas'] }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Tab content -->
                            <div class="tab-content" id="kelasTabsContent">
                                @foreach ($detailAbsensiPerKelas as $index => $kelas)
                                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                        id="kelas-{{ $index }}" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>NIS</th>
                                                        <th>Nama Siswa</th>
                                                        <th>Status</th>
                                                        <th>Jam Masuk</th>
                                                        <th>Jam Pulang</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($kelas['siswa'] as $key => $siswa)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $siswa['nis'] }}</td>
                                                            <td>{{ $siswa['nama'] }}</td>
                                                            <td>
                                                                @if ($siswa['status'] == 'hadir')
                                                                    <span class="badge bg-success">Hadir</span>
                                                                @elseif($siswa['status'] == 'tepat_waktu')
                                                                    <span class="badge bg-success">Tepat Waktu</span>
                                                                @elseif($siswa['status'] == 'terlambat')
                                                                    <span class="badge bg-warning">Terlambat</span>
                                                                @elseif($siswa['status'] == 'izin')
                                                                    <span class="badge bg-info">Izin</span>
                                                                @elseif($siswa['status'] == 'sakit')
                                                                    <span class="badge bg-warning">Sakit</span>
                                                                @elseif($siswa['status'] == 'alfa')
                                                                    <span class="badge bg-danger">Alfa</span>
                                                                @elseif($siswa['status'] == 'dinas')
                                                                    <span class="badge bg-primary">Dinas</span>
                                                                @else
                                                                    <span class="badge bg-secondary">Belum Absen</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $siswa['jam_masuk'] ? $siswa['jam_masuk']->format('H:i') : '-' }}
                                                            </td>
                                                            <td>{{ $siswa['jam_pulang'] ? $siswa['jam_pulang']->format('H:i') : '-' }}
                                                            </td>
                                                            <td>{{ $siswa['keterangan'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UNTUK SISWA BELUM DIKONFIRMASI -->
    <div class="modal fade" id="modalBelumDikonfirmasi" tabindex="-1" aria-labelledby="modalBelumDikonfirmasiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalBelumDikonfirmasiLabel">
                        Daftar Siswa Belum Dikonfirmasi Hari Ini
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <span class="badge bg-warning fs-5" id="countBelumDikonfirmasi">0 SISWA</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA</th>
                                    <th>IDUKA</th>
                                    <th>PEMBIMBING</th>
                                    <th>JENIS</th>
                                    <th>KETERANGAN</th>
                                    <th>WAKTU ABSEN</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyBelumDikonfirmasi">
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="spinner-border text-warning" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Memuat data...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="errorMessageBelumDikonfirmasi" class="text-center py-4 d-none">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                        <p class="mb-0">Gagal memuat data. Silakan coba lagi.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UNTUK SISWA BELUM ABSEN -->
    <div class="modal fade" id="modalBelumAbsen" tabindex="-1" aria-labelledby="modalBelumAbsenLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalBelumAbsenLabel">
                        Daftar Siswa Tidak Hadir Hari Ini
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <span class="badge bg-danger fs-5" id="countBelumAbsen">0 SISWA</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA</th>
                                    <th>IDUKA</th>
                                    <th>PEMBIMBING</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyBelumAbsen">
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="spinner-border text-danger" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Memuat data...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="errorMessage" class="text-center py-4 d-none">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                        <p class="mb-0">Gagal memuat data. Silakan coba lagi.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .card {
            border-radius: 16px;
            transition: all 0.3s ease;
            border: none !important;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12) !important;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .text-secondary {
            color: #6c757d !important;
        }

        .rounded-4 {
            border-radius: 12px !important;
        }

        .btn {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-dark {
            background-color: #212529;
            border-color: #212529;
        }

        .btn-light {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #495057;
        }

        .badge {
            font-weight: 500;
            padding: 0.5em 1em;
        }

        .bg-dark {
            background-color: #212529 !important;
        }

        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15);
            border: none;
        }

        .list-group-item {
            transition: background-color 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        h6 {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .small {
            font-size: 0.85rem;
        }

        .shadow-sm {
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08) !important;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        .fw-semibold {
            font-weight: 600 !important;
        }

        /* Tambahan CSS untuk tab dan tabel */
        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 500;
            border: none;
            border-bottom: 2px solid transparent;
            border-radius: 0;
            padding: 0.75rem 1rem;
        }

        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: #212529;
        }

        .nav-tabs .nav-link.active {
            color: #212529;
            background-color: transparent;
            border-bottom: 2px solid #212529;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .badge {
            font-size: 0.75em;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 8px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            border-bottom: none;
            padding: 1rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
            cursor: pointer;
        }

        .btn-close:focus {
            box-shadow: none;
        }

        /* Animasi untuk modal */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translate(0, -50px);
        }

        .modal.show .modal-dialog {
            transform: translate(0, 0);
        }

        /* Spinner styling */
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let attendanceChart;
            let majorChart;

            // ====== Grafik Absensi Harian (Line Chart) ======
            function loadAttendanceChart(filter = '7') {
                fetch(`/absensi/chart-data?filter=${filter}`)
                    .then(res => res.json())
                    .then(data => {
                        const ctx = document.getElementById('attendanceChart').getContext('2d');

                        // Hapus chart lama kalau ada
                        if (attendanceChart) {
                            attendanceChart.destroy();
                        }

                        attendanceChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Hadir',
                                    data: data.values,
                                    borderColor: '#212529',
                                    backgroundColor: 'rgba(33, 37, 41, 0.1)',
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#212529',
                                    pointBorderWidth: 0,
                                    pointRadius: 6
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        border: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: '#f1f3f4',
                                            drawBorder: false
                                        },
                                        border: {
                                            display: false
                                        },
                                        ticks: {
                                            color: '#6c757d'
                                        }
                                    }
                                },
                                elements: {
                                    point: {
                                        hoverRadius: 8
                                    }
                                }
                            }
                        });
                    });
            }

            // Default tampil "7 Hari Terakhir"
            loadAttendanceChart('7');

            // Klik dropdown filter
            document.querySelectorAll('.chart-filter').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const filter = this.dataset.filter;
                    document.getElementById('chartFilterBtn').innerText = this.innerText;
                    loadAttendanceChart(filter);
                });
            });

            // ====== Grafik Distribusi per Kelas (Doughnut Chart) ======
            function loadKelasChart() {
                const data = {
                    labels: @json($kelasLabels),
                    values: @json($kelasValues)
                };

                const ctx = document.getElementById('majorChart').getContext('2d');

                // Hapus chart lama kalau ada
                if (majorChart) {
                    majorChart.destroy();
                }

                majorChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: [
                                '#3498db', '#16a085', '#e67e22', '#8e44ad',
                                '#27ae60', '#f39c12', '#e74c3c', '#9b59b6'
                            ],
                            borderWidth: 0,
                            cutout: '65%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 15,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            }

            loadKelasChart();

            // ====== Animasi Kartu Dashboard ======
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // ====== Refresh Data ======
            document.getElementById('refreshBtn').addEventListener('click', function() {
                location.reload();
            });

            // Refresh data analisis
            document.getElementById('refreshAnalisis')?.addEventListener('click', function() {
                fetch(window.location.href)
                    .then(response => response.text())
                    .then(html => {
                        // Buat DOM parser
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Ambil elemen analisis kehadiran dari response
                        const newAnalisis = doc.querySelector('#analisisKehadiranContainer');

                        // Ganti elemen saat ini dengan yang baru
                        if (newAnalisis) {
                            document.getElementById('analisisKehadiranContainer').innerHTML =
                                newAnalisis.innerHTML;
                        }
                    })
                    .catch(error => {
                        console.error('Error refreshing data:', error);
                        // Alternatif: reload halaman
                        window.location.reload();
                    });
            });

            // Fungsi untuk memuat data siswa belum dikonfirmasi
            function loadSiswaBelumDikonfirmasi() {
                // Tampilkan loading
                document.getElementById('tbodyBelumDikonfirmasi').innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <div class="spinner-border text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat data...</p>
                    </td>
                </tr>
            `;

                // Sembunyikan pesan error
                document.getElementById('errorMessageBelumDikonfirmasi').classList.add('d-none');

                fetch("{{ route('kaprog.siswa-belum-dikonfirmasi') }}")
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        let tbody = document.getElementById('tbodyBelumDikonfirmasi');
                        let countElement = document.getElementById('countBelumDikonfirmasi');

                        // Update count
                        countElement.textContent = `${data.length} SISWA`;

                        // Kosongkan tbody
                        tbody.innerHTML = '';

                        if (data.length === 0) {
                            tbody.innerHTML = `
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-check-circle text-success fa-3x mb-3 d-block"></i>
                                    <p class="mb-0">Tidak ada siswa yang perlu dikonfirmasi hari ini</p>
                                </td>
                            </tr>
                        `;
                            return;
                        }

                        // Tambahkan data ke tabel
                        data.forEach(siswa => {
                            let row = `
                            <tr>
                                <td>${siswa.no}</td>
                                <td>${siswa.name}</td>
                                <td>${siswa.iduka}</td>
                                <td>${siswa.pembimbing}</td>
                                <td>
                                    <span class="badge ${siswa.jenis === 'Absensi' ? 'bg-warning' : (siswa.jenis === 'Izin' ? 'bg-info' : 'bg-primary')}">${siswa.jenis}</span>
                                </td>
                                <td>${siswa.keterangan}</td>
                                <td>${siswa.waktu_absen}</td>
                            </tr>
                        `;
                            tbody.innerHTML += row;
                        });

                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Tampilkan pesan error
                        document.getElementById('tbodyBelumDikonfirmasi').innerHTML = '';
                        document.getElementById('errorMessageBelumDikonfirmasi').classList.remove('d-none');

                        // Update count
                        document.getElementById('countBelumDikonfirmasi').textContent = '0 SISWA';
                    });
            }

            // Fungsi untuk memuat data siswa belum absen
            function loadSiswaBelumAbsen() {
                console.log('Memulai loadSiswaBelumAbsen');

                // Tampilkan loading
                document.getElementById('tbodyBelumAbsen').innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat data...</p>
                    </td>
                </tr>
            `;

                // Sembunyikan pesan error
                document.getElementById('errorMessage').classList.add('d-none');

                fetch("{{ route('kaprog.siswa-belum-absen') }}")
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Data received:', data);

                        let tbody = document.getElementById('tbodyBelumAbsen');
                        let countElement = document.getElementById('countBelumAbsen');

                        // Update count
                        countElement.textContent = `${data.length} SISWA`;

                        // Kosongkan tbody
                        tbody.innerHTML = '';

                        if (data.length === 0) {
                            tbody.innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="fas fa-check-circle text-success fa-3x mb-3 d-block"></i>
                                    <p class="mb-0">Semua siswa sudah melakukan absensi hari ini</p>
                                </td>
                            </tr>
                        `;
                            return;
                        }

                        // Tambahkan data ke tabel
                        data.forEach(siswa => {
                            let row = `
                            <tr>
                                <td>${siswa.no}</td>
                                <td>${siswa.name}</td>
                                <td>${siswa.iduka}</td>
                                <td>${siswa.pembimbing}</td>
                            </tr>
                        `;
                            tbody.innerHTML += row;
                        });

                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Tampilkan pesan error
                        document.getElementById('tbodyBelumAbsen').innerHTML = '';
                        document.getElementById('errorMessage').classList.remove('d-none');

                        // Update count
                        document.getElementById('countBelumAbsen').textContent = '0 SISWA';
                    });
            }

            // Event saat modal dibuka - Siswa Belum Dikonfirmasi
            const modalBelumDikonfirmasi = document.getElementById('modalBelumDikonfirmasi');
            if (modalBelumDikonfirmasi) {
                modalBelumDikonfirmasi.addEventListener('show.bs.modal', function(event) {
                    loadSiswaBelumDikonfirmasi();
                });
            }

            // Event saat modal dibuka - Siswa Belum Absen
            const modalBelumAbsen = document.getElementById('modalBelumAbsen');
            if (modalBelumAbsen) {
                modalBelumAbsen.addEventListener('show.bs.modal', function(event) {
                    loadSiswaBelumAbsen();
                });
            }
        });
    </script>
@endsection
