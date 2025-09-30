@extends('layout.main')

@section('content')
    <div class="container-fluid"><br>
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <!-- Tambahkan notifikasi session jika ada -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <!-- Sidebar Konfirmasi Absen -->
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Menu Konfirmasi</h5>
                            </div>
                            <div class="card-body">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <button class="nav-link active" id="v-pills-hari-ini-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-hari-ini" type="button" role="tab"
                                        aria-controls="v-pills-hari-ini" aria-selected="true">
                                        <i class="bi bi-calendar-check me-2"></i>Absen Hari Ini
                                    </button>
                                    <button class="nav-link" id="v-pills-absen-pending-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-absen-pending" type="button" role="tab"
                                        aria-controls="v-pills-absen-pending" aria-selected="false">
                                        <i class="bi bi-clock-history me-2"></i>Absensi Pending
                                        <span class="badge bg-warning ms-2"
                                            id="badge-absen-pending">{{ $absensiPending->count() }}</span>
                                    </button>
                                    <button class="nav-link" id="v-pills-perlu-konfirmasi-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-perlu-konfirmasi" type="button" role="tab"
                                        aria-controls="v-pills-perlu-konfirmasi" aria-selected="false">
                                        <i class="bi bi-clock-history me-2"></i>Perlu Konfirmasi
                                        <span class="badge bg-danger ms-2"
                                            id="badge-pending">{{ $izinPending->count() }}</span>
                                    </button>
                                    <button class="nav-link" id="v-pills-riwayat-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-riwayat" type="button" role="tab"
                                        aria-controls="v-pills-riwayat" aria-selected="false">
                                        <i class="bi bi-list-check me-2"></i>Riwayat Absen
                                    </button>
                                    <button class="nav-link" id="v-pills-statistik-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-statistik" type="button" role="tab"
                                        aria-controls="v-pills-statistik" aria-selected="false">
                                        <i class="bi bi-bar-chart me-2"></i>Statistik
                                    </button>
                                </div>

                                <hr>
                            </div>
                        </div>
                    </div>

                    <!-- Konten Utama -->
                    <div class="col-lg-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <!-- Tab Absen Hari Ini -->
                            <div class="tab-pane fade show active" id="v-pills-hari-ini" role="tabpanel"
                                aria-labelledby="v-pills-hari-ini-tab">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Absensi Hari Ini</h5>
                                        <div>
                                            <span class="badge bg-primary" id="tanggal-hari-ini">{{ date('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tabel-absen-hari-ini">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Siswa</th>
                                                        <th>Masuk</th>
                                                        <th>Pulang</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($absensiHariIni as $absensi)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset('snet/assets/img/avatars/1.png') }}"
                                                                        alt="Avatar" class="rounded-circle me-2"
                                                                        width="32" height="32">
                                                                    <div class="ms-2">
                                                                        <div class="fw-semibold">
                                                                            {{ $absensi->user->name }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $absensi->user->email }}</div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if ($absensi->jam_masuk)
                                                                    <span
                                                                        class="badge bg-success">{{ $absensi->jam_masuk }}</span>
                                                                @else
                                                                    <span class="badge bg-secondary">-</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($absensi->jam_pulang)
                                                                    <span
                                                                        class="badge bg-info">{{ $absensi->jam_pulang }}</span>
                                                                @else
                                                                    <span class="badge bg-secondary">-</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge {{ $absensi->status === 'tepat_waktu'
                                                                        ? 'bg-success'
                                                                        : ($absensi->status === 'terlambat'
                                                                            ? 'bg-warning'
                                                                            : ($absensi->status === 'izin'
                                                                                ? 'bg-info'
                                                                                : ($absensi->status === 'ditolak'
                                                                                    ? 'bg-danger'
                                                                                    : 'bg-secondary'))) }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $absensi->status)) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">Belum ada
                                                                data
                                                                absensi hari ini</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Absensi Pending -->
                            <div class="tab-pane fade" id="v-pills-absen-pending" role="tabpanel"
                                aria-labelledby="v-pills-absen-pending-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Absensi Menunggu Konfirmasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('iduka.konfirmasi-banyak-absen') }}"
                                            id="formKonfirmasiBanyak">
                                            @csrf
                                            <div class="d-flex justify-content-between mb-3">
                                                <div>
                                                    <input type="checkbox" id="check-all" onchange="toggleAll(this)">
                                                    <label for="check-all" class="ms-1">Pilih Semua</label>
                                                </div>
                                                <div>
                                                    <button type="submit" name="status" value="disetujui"
                                                        class="btn btn-sm btn-success me-1"
                                                        onclick="return confirm('Apakah Anda yakin ingin menyetujui absensi yang dipilih?')">
                                                        <i class="bi bi-check-lg"></i> Setujui yang Dipilih
                                                    </button>
                                                    <button type="submit" name="status" value="ditolak"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menolak absensi yang dipilih?')">
                                                        <i class="bi bi-x-lg"></i> Tolak yang Dipilih
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th width="50"></th>
                                                            <th>Nama Siswa</th>
                                                            <th>Tanggal</th>
                                                            <th>Jenis</th>
                                                            <th>Waktu</th>
                                                            <th width="150">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody-absensi-pending">
                                                        @forelse($absensiPending as $absensi)
                                                            <tr id="row-pending-{{ $absensi->id }}">
                                                                <td>
                                                                    <input type="checkbox" name="absen_ids[]"
                                                                        value="{{ $absensi->id }}" class="absen-check">
                                                                </td>
                                                                <td>{{ $absensi->user->name }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge {{ $absensi->jenis === 'masuk' ? 'bg-success' : 'bg-info' }}">
                                                                        {{ ucfirst($absensi->jenis) }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($absensi->jam)->format('H:i') }}
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group" role="group">
                                                                        <button type="button"
                                                                            class="btn btn-success btn-sm"
                                                                            onclick="konfirmasiAbsensi({{ $absensi->id }}, 'disetujui')"
                                                                            title="Setujui">
                                                                            <i class="bi bi-check-lg"></i>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm"
                                                                            onclick="konfirmasiAbsensi({{ $absensi->id }}, 'ditolak')"
                                                                            title="Tolak">
                                                                            <i class="bi bi-x-lg"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr id="no-data-pending">
                                                                <td colspan="7" class="text-center text-muted">
                                                                    Tidak ada absensi yang perlu dikonfirmasi
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Perlu Konfirmasi -->
                            <div class="tab-pane fade" id="v-pills-perlu-konfirmasi" role="tabpanel"
                                aria-labelledby="v-pills-perlu-konfirmasi-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Izin Perlu Konfirmasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Siswa</th>
                                                        <th>Tanggal</th>
                                                        <th>Jenis</th>
                                                        <th>Alasan</th>
                                                        <th>File</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($izinPending as $izin)
                                                        <tr data-izin-id="{{ $izin->id }}">
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset('snet/assets/img/avatars/1.png') }}"
                                                                        alt="Avatar" class="rounded-circle me-2"
                                                                        width="32" height="32">
                                                                    <div class="ms-2">
                                                                        <div class="fw-semibold">{{ $izin->user->name }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $izin->created_at->format('d M Y H:i') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $izin->tanggal_izin ? $izin->tanggal_izin->format('d M Y') : $izin->created_at->format('d M Y') }}
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge {{ $izin->jenis_izin === 'sakit' ? 'bg-danger' : ($izin->jenis_izin === 'izin' ? 'bg-info' : 'bg-warning') }}">
                                                                    {{ ucfirst($izin->jenis_izin) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="text-truncate d-inline-block"
                                                                    style="max-width: 200px;"
                                                                    title="{{ $izin->alasan ?? $izin->keterangan }}">
                                                                    {{ $izin->alasan ?? $izin->keterangan }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if ($izin->file_pendukung)
                                                                    <a href="{{ Storage::url($izin->file_pendukung) }}"
                                                                        target="_blank"
                                                                        class="btn btn-sm btn-outline-secondary">
                                                                        <i class="bi bi-file-earmark"></i>
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-warning">
                                                                    {{ isset($izin->status_label) ? $izin->status_label : 'Pending' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="konfirmasiIzin({{ $izin->id }}, 'disetujui')"
                                                                        title="Setujui">
                                                                        <i class="bi bi-check-lg"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="konfirmasiIzin({{ $izin->id }}, 'ditolak')"
                                                                        title="Tolak">
                                                                        <i class="bi bi-x-lg"></i>
                                                                    </button>
                                                                    <a href="{{ route('iduka.detail-izin', $izin->id) }}"
                                                                        class="btn btn-sm btn-outline-primary"
                                                                        title="Detail">
                                                                        <i class="bi bi-eye"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center text-muted">Tidak ada
                                                                izin yang perlu dikonfirmasi</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Riwayat Absen -->
                            <div class="tab-pane fade" id="v-pills-riwayat" role="tabpanel"
                                aria-labelledby="v-pills-riwayat-tab">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Riwayat Absensi</h5>
                                        <form id="filterRiwayatForm" class="d-flex gap-2">
                                            <input type="date" class="form-control form-control-sm"
                                                name="tanggal_dari" id="tanggal_dari">
                                            <input type="date" class="form-control form-control-sm"
                                                name="tanggal_sampai" id="tanggal_sampai">
                                            <select class="form-select form-select-sm" style="width: 150px;"
                                                name="filter_siswa_riwayat" id="filter_siswa_riwayat">
                                                <option value="">Semua Siswa</option>
                                                @foreach ($siswaList as $siswa)
                                                    <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-outline-secondary btn-sm" type="submit">
                                                <i class="bi bi-funnel"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Nama Siswa</th>
                                                        <th>Masuk</th>
                                                        <th>Pulang</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="riwayatBody">
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">Gunakan filter
                                                            untuk
                                                            melihat data</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Statistik -->
                            <div class="tab-pane fade" id="v-pills-statistik" role="tabpanel"
                                aria-labelledby="v-pills-statistik-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Statistik Kehadiran Bulan Ini</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-4">
                                                    <div class="col-md-3">
                                                        <div class="card text-center">
                                                            <div class="card-body">
                                                                <i class="bi bi-check-circle text-success"
                                                                    style="font-size: 2rem;"></i>
                                                                <h4 class="mt-2">
                                                                    {{ $statistik['persentase_kehadiran'] }}%
                                                                </h4>
                                                                <p class="text-muted mb-0">Rata-rata Kehadiran</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="card text-center">
                                                            <div class="card-body">
                                                                <i class="bi bi-clock text-warning"
                                                                    style="font-size: 2rem;"></i>
                                                                <h4 class="mt-2">{{ $statistik['terlambat'] }}</h4>
                                                                <p class="text-muted mb-0">Total Keterlambatan</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="card text-center">
                                                            <div class="card-body">
                                                                <i class="bi bi-x-circle text-danger"
                                                                    style="font-size: 2rem;"></i>
                                                                <h4 class="mt-2">{{ $statistik['alpha'] }}</h4>
                                                                <p class="text-muted mb-0">Total Alpha</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="card text-center">
                                                            <div class="card-body">
                                                                <i class="bi bi-e-earmark-text text-info"
                                                                    style="font-size: 2rem;"></i>
                                                                <h4 class="mt-2">{{ $statistik['izin'] }}</h4>
                                                                <p class="text-muted mb-0">Total Izin</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Statistik per Siswa</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <canvas id="chartStatistikSiswa" height="250"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Persentase Kehadiran</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <canvas id="chartPieKehadiran" height="250"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Izin -->
    <div class="modal fade" id="modalDetailIzin" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Permohonan Izin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalDetailIzinContent">
                    <!-- Content will be loaded via controller -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk toggle semua checkbox - IMPROVED
        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('.absen-check');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
        }

        // Fungsi untuk konfirmasi absensi individual - FIXED
        function konfirmasiAbsensi(pendingId, status) {
            if (status === 'ditolak') {
                konfirmasiTolakAbsensi(pendingId);
                return;
            }

            if (!confirm(`Apakah Anda yakin ingin menyetujui absensi ini?`)) {
                return;
            }

            // Show loading
            const row = document.getElementById(`row-pending-${pendingId}`);
            if (row) {
                row.style.opacity = '0.5';
            }

            fetch(`{{ route('iduka.konfirmasi-absen.proses', ':id') }}`.replace(':id', pendingId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })

                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response:', data);

                    if (data.success) {
                        // Show success message
                        showAlert('success', data.message);

                        // Remove row from pending table
                        if (row) {
                            row.remove();
                        }

                        // Update badge counter
                        updatePendingCounter();

                        // Reload absen hari ini jika perlu
                        if (status === 'disetujui') {
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }

                        // Check if no more pending data
                        const tbody = document.getElementById('tbody-absensi-pending');
                        const remainingRows = tbody.querySelectorAll('tr:not(#no-data-pending)');
                        if (remainingRows.length === 0) {
                            tbody.innerHTML = `
                    <tr id="no-data-pending">
                        <td colspan="7" class="text-center text-muted">
                            Tidak ada absensi yang perlu dikonfirmasi
                        </td>
                    </tr>
                `;
                        }

                    } else {
                        showAlert('error', data.message || 'Terjadi kesalahan');
                        // Restore row
                        if (row) {
                            row.style.opacity = '1';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'Terjadi kesalahan koneksi: ' + error.message);
                    // Restore row
                    if (row) {
                        row.style.opacity = '1';
                    }
                });
        }

        // Fungsi khusus untuk menolak absensi
        function konfirmasiTolakAbsensi(pendingId) {
            const alasan = prompt('Masukkan alasan penolakan absensi:');

            if (alasan === null) {
                return; // User membatalkan
            }

            if (alasan.trim() === '') {
                alert('Alasan penolakan harus diisi!');
                return;
            }

            if (!confirm(`Apakah Anda yakin ingin menolak absensi ini?\nAlasan: ${alasan}`)) {
                return;
            }

            // Show loading
            const row = document.getElementById(`row-pending-${pendingId}`);
            if (row) {
                row.style.opacity = '0.5';
            }

            // Gunakan route tolak-absen yang baru
            fetch(`{{ route('iduka.tolak-absen', ':id') }}`.replace(':id', pendingId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        catatan: alasan
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response:', data);

                    if (data.success) {
                        // Show success message
                        showAlert('success', data.message);

                        // Remove row from pending table
                        if (row) {
                            row.remove();
                        }

                        // Update badge counter
                        updatePendingCounter();

                        // Check if no more pending data
                        const tbody = document.getElementById('tbody-absensi-pending');
                        const remainingRows = tbody.querySelectorAll('tr:not(#no-data-pending)');
                        if (remainingRows.length === 0) {
                            tbody.innerHTML = `
                        <tr id="no-data-pending">
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada absensi yang perlu dikonfirmasi
                            </td>
                        </tr>
                    `;
                        }

                    } else {
                        showAlert('error', data.message || 'Terjadi kesalahan');
                        // Restore row
                        if (row) {
                            row.style.opacity = '1';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'Terjadi kesalahan koneksi: ' + error.message);
                    // Restore row
                    if (row) {
                        row.style.opacity = '1';
                    }
                });
        }

        // Fungsi untuk menampilkan alert
        function showAlert(type, message) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => {
                if (alert.classList.contains('alert-success') || alert.classList.contains('alert-danger') || alert
                    .classList.contains('alert-warning')) {
                    alert.remove();
                }
            });

            // Create new alert
            const alertClass = type === 'success' ? 'alert-success' : (type === 'error' ? 'alert-danger' : 'alert-warning');
            const iconClass = type === 'success' ? 'bi-check-circle' : (type === 'error' ? 'bi-exclamation-triangle' :
                'bi-info-circle');

            const alertDiv = document.createElement('div');
            alertDiv.className = `alert ${alertClass} alert-dismissible fade show`;
            alertDiv.innerHTML = `
        <i class="${iconClass} me-2"></i>
        <strong>${type === 'success' ? 'Berhasil!' : 'Error!'}</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

            // Insert at top of content
            const container = document.querySelector('.container-xxl');
            if (container) {
                container.insertBefore(alertDiv, container.firstChild);
            }

            // Auto hide after 3 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }

        // Update badge counter
        function updatePendingCounter() {
            const badge = document.getElementById('badge-absen-pending');
            if (badge) {
                const currentCount = parseInt(badge.textContent) || 0;
                const newCount = Math.max(0, currentCount - 1);
                badge.textContent = newCount;

                if (newCount === 0) {
                    badge.style.display = 'none';
                }
            }
        }

        // Handle form submission for bulk confirmation
        document.getElementById('formKonfirmasiBanyak')?.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.absen-check:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                showAlert('warning', 'Silakan pilih minimal satu absensi untuk dikonfirmasi');
                return false;
            }
        });

        function formatTime(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            const pad = n => n.toString().padStart(2, '0');
            return `${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
        }

        //filter
        function loadRiwayat(params = {}) {
            let url = "{{ route('iduka.filter-riwayat') }}?" + new URLSearchParams(params);

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    let tbody = document.getElementById('riwayatBody');
                    tbody.innerHTML = "";

                    if (!res.success || res.data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>`;
                        return;
                    }

                    res.data.forEach(absensi => {
                        tbody.innerHTML += `
                    <tr>
                        <td>${new Date(absensi.tanggal).toLocaleDateString('id-ID')}</td>
                        <td>${absensi.user.name}</td>
                       <td>${formatTime(absensi.jam_masuk)}</td>
<td>${formatTime(absensi.jam_pulang)}</td>
                        <td>
                           <span class="badge {{ $absensi->status === 'tepat_waktu'
                               ? 'bg-success'
                               : ($absensi->status === 'terlambat'
                                   ? 'bg-warning'
                                   : ($absensi->status === 'izin'
                                       ? 'bg-info'
                                       : ($absensi->status === 'ditolak'
                                           ? 'bg-danger'
                                           : 'bg-secondary'))) }}">
    {{ ucfirst(str_replace('_', ' ', $absensi->status)) }}
</span>
                        </td>
                    </tr>
                `;
                    });
                })
                .catch(err => console.error(err));
        }

        // ✅ load data default saat halaman dibuka
        document.addEventListener('DOMContentLoaded', function() {
            // Set default tanggal (7 hari terakhir)
            const tanggalSampai = new Date().toISOString().split('T')[0];
            const tanggalDari = new Date();
            tanggalDari.setDate(tanggalDari.getDate() - 7);
            const tanggalDariFormatted = tanggalDari.toISOString().split('T')[0];

            document.getElementById('tanggal_dari').value = tanggalDariFormatted;
            document.getElementById('tanggal_sampai').value = tanggalSampai;

            // Load data dengan filter default
            loadRiwayat({
                tanggal_dari: tanggalDariFormatted,
                tanggal_sampai: tanggalSampai
            });
        });

        // ✅ jika ada form filter
        document.getElementById('filterRiwayatForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            loadRiwayat(Object.fromEntries(formData.entries()));
        });

        //konfir izin
        function konfirmasiIzin(izinId, status) {
            if (!confirm(`Apakah Anda yakin ingin ${status === 'disetujui' ? 'menyetujui' : 'menolak'} izin ini?`)) {
                return;
            }

            let catatan = null;
            if (status === 'ditolak') {
                catatan = prompt('Masukkan alasan penolakan:');
                if (catatan === null) return; // User membatalkan
                if (catatan.trim() === '') {
                    alert('Alasan penolakan harus diisi!');
                    return;
                }
            }

            // Show loading
            const row = document.querySelector(`tr[data-izin-id="${izinId}"]`);
            if (row) {
                row.style.opacity = '0.5';
            }

            // Kirim permintaan AJAX untuk konfirmasi izin
            fetch(`{{ route('iduka.konfirmasi-izin', '') }}/${izinId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status,
                        catatan: catatan
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response:', data);

                    if (data.success) {
                        // Show success message
                        showAlert('success', data.message);

                        // Remove row from table
                        if (row) {
                            row.remove();
                        }

                        // Update badge counter
                        updateIzinPendingCounter();

                        // Check if no more pending data
                        const tbody = document.querySelector('#v-pills-perlu-konfirmasi tbody');
                        const remainingRows = tbody.querySelectorAll('tr');
                        if (remainingRows.length === 0) {
                            tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Tidak ada izin yang perlu dikonfirmasi
                        </td>
                    </tr>
                `;
                        }
                    } else {
                        showAlert('error', data.message || 'Terjadi kesalahan');
                        // Restore row
                        if (row) {
                            row.style.opacity = '1';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'Terjadi kesalahan koneksi: ' + error.message);
                    // Restore row
                    if (row) {
                        row.style.opacity = '1';
                    }
                });
        }

        // Update badge counter untuk izin pending
        function updateIzinPendingCounter() {
            const badge = document.getElementById('badge-pending');
            if (badge) {
                const currentCount = parseInt(badge.textContent) || 0;
                const newCount = Math.max(0, currentCount - 1);
                badge.textContent = newCount;

                if (newCount === 0) {
                    badge.style.display = 'none';
                }
            }
        }
    </script>
@endsection
