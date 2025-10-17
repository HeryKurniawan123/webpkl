@extends('layout.main')

@section('content')
    <div class="container-fluid">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Simple Header Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 bg-white shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 cla   ss="mb-1 text-dark fw-bold">Dashboard PKL & Absensi</h4>
                                    <p class="text-secondary mb-0">Monitoring kehadiran dan data siswa PKL</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-light border">
                                        <a href="{{ route('export.jurusan') }}">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </a>
                                    </button>
                                    <!-- TOMBOL BARU UNTUK SISWA BELUM ABSEN -->
                                    <button class="btn btn-danger border" data-bs-toggle="modal" data-bs-target="#modalBelumAbsen">
                                        <i class="fas fa-user-slash"></i> Siswa Belum Absen
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
                                    <p class="text-secondary mb-0 small">Total Siswa PKL</p>
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
                                    <i class="fas fa-user-times fa-2x" style="color: #e67e22;"></i>
                                </div>
                                <div>
                                    <h3 class="mb-1 fw-bold text-dark">{{ $tidakHadir }}</h3>
                                    <p class="text-secondary mb-0 small">Tidak Hadir</p>
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
                                    <i class="fas fa-chart-line fa-2x" style="color: #8e44ad;"></i>
                                </div>
                                <div>
                                    <h3 class="mb-1 fw-bold text-dark">{{ $tingkatKehadiran }}</h3>
                                    <p class="text-secondary mb-0 small">Tingkat Kehadiran</p>
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

                <!-- Distribusi per Jurusan -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-4">
                            <h5 class="mb-0 fw-semibold text-dark">Distribusi Jurusan</h5>
                        </div>
                        <div class="card-body p-4">
                            <canvas id="majorChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analisis Kehadiran per Jurusan -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-4">
                            <h5 class="mb-0 fw-semibold text-dark">Analisis Kehadiran per Jurusan</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                @foreach ($jurusanData as $j)
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <div class="text-center p-3 bg-light rounded-4">
                                            <div class="mb-3">
                                                {{-- <i class="fas fa-school fa-2x text-dark mb-2"></i> --}}
                                                <h6 class="mb-0 fw-semibold text-dark">{{ $j['jurusan'] }}</h6>
                                            </div>
                                            <div class="h4 mb-1 fw-bold"
                                                style="color: {{ $j['persentase'] >= 90 ? '#27ae60' : ($j['persentase'] >= 85 ? '#f39c12' : '#e74c3c') }};">
                                                {{ $j['persentase'] }}%
                                            </div>
                                            <small class="text-secondary">{{ $j['total_siswa'] }} siswa</small>
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

    <!-- MODAL BARU UNTUK SISWA BELUM ABSEN -->
    <div class="modal fade" id="modalBelumAbsen" tabindex="-1" aria-labelledby="modalBelumAbsenLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalBelumAbsenLabel">
                        Daftar Siswa Belum Absen Hari Ini
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <th>EMAIL</th>
                                    <th>NIP</th>
                                    <th>IDUKA</th>
                                    <th>PEMBIMBING ID</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyBelumAbsen">
                                <tr>
                                    <td colspan="6" class="text-center py-4">
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

        .badge {
            font-weight: 500;
            padding: 0.4em 0.8em;
            font-size: 0.75rem;
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
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let attendanceChart;

            // Fungsi untuk load chart berdasarkan filter
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
                    })
                    .catch(error => {
                        console.error('Error loading attendance chart:', error);
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

            // Grafik Distribusi Jurusan (statis dulu)
            const majorCtx = document.getElementById('majorChart').getContext('2d');
            const majorChart = new Chart(majorCtx, {
                type: 'doughnut',
                data: {
                    labels: ['RPL', 'TKJ', 'PG', 'TKRO', 'MP', 'AKL', 'SK', 'DPB'],
                    datasets: [{
                        data: [28, 24, 22, 26, 25, 23, 18, 21], // ini bisa ambil dari DB juga
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

            // Animasi kartu
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

            // Event saat modal dibuka
            document.getElementById('modalBelumAbsen').addEventListener('show.bs.modal', function (event) {
                loadSiswaBelumAbsen();
            });

            // Fungsi untuk memuat data siswa belum absen
            function loadSiswaBelumAbsen() {
                // Tampilkan loading
                document.getElementById('tbodyBelumAbsen').innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="spinner-border text-danger" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Memuat data...</p>
                        </td>
                    </tr>
                `;

                // Sembunyikan pesan error
                document.getElementById('errorMessage').classList.add('d-none');

                fetch('/data-absensi/siswa-belum-absen')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        let tbody = document.getElementById('tbodyBelumAbsen');
                        let countElement = document.getElementById('countBelumAbsen');

                        // Update count
                        countElement.textContent = `${data.length} SISWA`;

                        // Kosongkan tbody
                        tbody.innerHTML = '';

                        if (data.length === 0) {
                            tbody.innerHTML = `
                                <tr>
                                    <td colspan="6" class="text-center py-4">
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
                                    <td>${siswa.email}</td>
                                    <td>${siswa.nip}</td>
                                    <td>${siswa.iduka_id}</td>
                                    <td>${siswa.pembimbing_id}</td>
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
        });

        // Grafik Distribusi Jurusan (ambil dari backend)
        function loadJurusanChart() {
            fetch('/absensi/jurusan-data')
                .then(res => res.json())
                .then(data => {
                    const majorCtx = document.getElementById('majorChart').getContext('2d');

                    new Chart(majorCtx, {
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
                })
                .catch(error => {
                    console.error('Error loading jurusan chart:', error);
                });
        }

        loadJurusanChart();
    </script>
@endsection
