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
                                    <button class="nav-link" id="v-pills-dinas-pending-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-dinas-pending" type="button" role="tab"
                                        aria-controls="v-pills-dinas-pending" aria-selected="false">
                                        <i class="bi bi-briefcase me-2"></i>Dinas Luar
                                        <span class="badge bg-primary ms-2"
                                            id="badge-dinas-pending">{{ $dinasPending->count() }}</span>
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
                                    <button class="nav-link" id="v-pills-kordinat-tab" type="button"
                                        onclick="alert('Fitur ini sedang dalam perbaikan, silakan coba lagi nanti!')">
                                        <i class="bi bi-bar-chart me-2"></i>Kordinat / Lokasi
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
                                            <span class="badge bg-primary"
                                                id="tanggal-hari-ini">{{ date('d F Y') }}</span>
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
                                                                @elseif ($absensi->status_dinas === 'disetujui')
                                                                    <span class="badge bg-primary">
                                                                        {{ \Carbon\Carbon::parse($absensi->created_at)->format('Y-m-d H:i:s') }}
                                                                    </span>
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
                                                    <input type="checkbox" id="check-all" class="form-check-input">
                                                    <label for="check-all" class="ms-2">Pilih Semua</label>
                                                </div>
                                                <div>
                                                    <button type="submit" name="status" value="disetujui"
                                                        class="btn btn-sm btn-success me-1">
                                                        <i class="bi bi-check-lg"></i> Setujui yang Dipilih
                                                    </button>
                                                    <button type="submit" name="status" value="ditolak"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="bi bi-x-lg"></i> Tolak yang Dipilih
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th width="50">
                                                                <input type="checkbox" id="check-all-header"
                                                                    class="form-check-input">
                                                            </th>
                                                            <th>Nama Siswa</th>
                                                            <th>Tanggal</th>
                                                            <th>Jenis</th>
                                                            <th>Waktu</th>
                                                            <th>Status Konfirmasi</th>
                                                            <th width="150">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody-absensi-pending">
                                                        @forelse($absensiPending as $absensi)
                                                            <tr id="row-pending-{{ $absensi->id }}">
                                                                <td>
                                                                    <input type="checkbox" name="absen_ids[]"
                                                                        value="{{ $absensi->id }}"
                                                                        class="form-check-input absen-check"
                                                                        data-id="{{ $absensi->id }}">
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
                                                                    @if ($absensi->dikonfirmasi_oleh)
                                                                        <span class="badge bg-info">
                                                                            {{ $absensi->dikonfirmasi_oleh === 'keduanya' ? 'IDUKA & Guru' : ucfirst($absensi->dikonfirmasi_oleh) }}
                                                                        </span>
                                                                    @else
                                                                        <span class="badge bg-warning">Belum
                                                                            dikonfirmasi</span>
                                                                    @endif
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

                            <div class="tab-pane fade" id="v-pills-dinas-pending" role="tabpanel"
                                aria-labelledby="v-pills-dinas-pending-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Dinas Luar Perlu Konfirmasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Siswa</th>
                                                        <th>Tanggal</th>
                                                        <th>Jenis Dinas</th>
                                                        <th>Alasan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($dinasPending as $dinas)
                                                        <tr data-dinas-id="{{ $dinas->id }}">
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset('snet/assets/img/avatars/1.png') }}"
                                                                        alt="Avatar" class="rounded-circle me-2"
                                                                        width="32" height="32">
                                                                    <div class="ms-2">
                                                                        <div class="fw-semibold">{{ $dinas->user->name }}
                                                                        </div>
                                                                        <div class="text-muted small">
                                                                            {{ $dinas->created_at->format('d M Y H:i') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $dinas->tanggal->format('d M Y') }}</td>
                                                            <td>
                                                                <span class="badge bg-primary">
                                                                    {{ ucfirst(str_replace('_', ' ', $dinas->jenis_dinas)) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="text-truncate d-inline-block"
                                                                    style="max-width: 200px;"
                                                                    title="{{ $dinas->keterangan }}">
                                                                    {{ $dinas->keterangan }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-warning">
                                                                    Pending
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <form method="POST"
                                                                        action="{{ route('iduka.konfirmasi-dinas', ['id' => $dinas->id]) }}"
                                                                        style="display: inline;">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="disetujui">
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-success"
                                                                            title="Setujui">
                                                                            <i class="bi bi-check-lg"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form method="POST"
                                                                        action="{{ route('iduka.konfirmasi-dinas', ['id' => $dinas->id]) }}"
                                                                        style="display: inline; margin-left: 5px;">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="ditolak">
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger" title="Tolak">
                                                                            <i class="bi bi-x-lg"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">Tidak ada
                                                                dinas luar yang perlu dikonfirmasi</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
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
                                                <!-- Di dalam tbody untuk izin pending -->
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
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-success btn-konfirmasi-izin"
                                                                        data-izin-id="{{ $izin->id }}"
                                                                        data-status="disetujui" title="Setujui">
                                                                        <i class="bi bi-check-lg"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger btn-konfirmasi-izin"
                                                                        data-izin-id="{{ $izin->id }}"
                                                                        data-status="ditolak" title="Tolak">
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

                            {{-- Tab Koordinat --}}
                            <div class="tab-pane fade" id="v-pills-kordinat" role="tabpanel"
                                aria-labelledby="v-pills-kordinat-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Tentukan Titik Koordinat</h5>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ route('iduka.tambah.kordinat') }}" method="POST">
                                                    @csrf

                                                    <div class="mb-3">
                                                        <label for="iduka_id">Pilih IDUKA</label>
                                                        <select name="iduka_id" id="iduka_id"
                                                            class="form-select select2">
                                                            <option value="">-- Pilih IDUKA --</option>
                                                            @foreach ($idukas as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ isset($iduka) && $iduka && $iduka->id == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Latitude</label>
                                                        <input type="text" name="latitude" class="form-control"
                                                            value="{{ old('latitude', $iduka->latitude ?? '') }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Longitude</label>
                                                        <input type="text" name="longitude" class="form-control"
                                                            value="{{ old('longitude', $iduka->longitude ?? '') }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Radius (meter)</label>
                                                        <input type="text" name="radius" class="form-control"
                                                            value="{{ old('radius', $iduka->radius ?? '') }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="jam_masuk" class="form-label">Jam Masuk (WIB)</label>
                                                        <div class="input-group">
                                                            <input type="time" class="form-control" id="jam_masuk"
                                                                name="jam_masuk"
                                                                value="{{ old('jam_masuk', $iduka->jam_masuk ?? '08:00') }}">
                                                            <span class="input-group-text">WIB</span>
                                                        </div>
                                                        <div class="form-text">Default: 08:00</div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="jam_pulang" class="form-label">Jam Pulang
                                                            (WIB)</label>
                                                        <div class="input-group">
                                                            <input type="time" class="form-control" id="jam_pulang"
                                                                name="jam_pulang"
                                                                value="{{ old('jam_pulang', $iduka->jam_pulang ?? '15:00') }}">
                                                            <span class="input-group-text">WIB</span>
                                                        </div>
                                                        <div class="form-text">Default: 15:00</div>
                                                    </div>


                                                    <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end --}}

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
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk toggle semua checkbox
            function toggleAll(source) {
                const checkboxes = document.querySelectorAll('.absen-check');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = source.checked;
                });
            }

            // Event listener untuk checkbox "Pilih Semua" di header
            const checkAllHeader = document.getElementById('check-all-header');
            if (checkAllHeader) {
                checkAllHeader.addEventListener('change', function() {
                    toggleAll(this);
                    // Sinkronkan dengan checkbox di luar tabel
                    const checkAllOutside = document.getElementById('check-all');
                    if (checkAllOutside) {
                        checkAllOutside.checked = this.checked;
                    }
                });
            }

            // Event listener untuk checkbox "Pilih Semua" di luar tabel
            const checkAllOutside = document.getElementById('check-all');
            if (checkAllOutside) {
                checkAllOutside.addEventListener('change', function() {
                    toggleAll(this);
                    // Sinkronkan dengan checkbox di header
                    const checkAllHeader = document.getElementById('check-all-header');
                    if (checkAllHeader) {
                        checkAllHeader.checked = this.checked;
                    }
                });
            }

            // Event listener untuk checkbox individual
            const individualCheckboxes = document.querySelectorAll('.absen-check');
            individualCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateCheckAllState();
                });
            });

            // Fungsi untuk memperbarui state checkbox "Pilih Semua"
            function updateCheckAllState() {
                const allCheckboxes = document.querySelectorAll('.absen-check');
                const checkedCheckboxes = document.querySelectorAll('.absen-check:checked');

                const checkAllHeader = document.getElementById('check-all-header');
                const checkAllOutside = document.getElementById('check-all');

                if (allCheckboxes.length === 0) return;

                const allChecked = allCheckboxes.length === checkedCheckboxes.length;
                const someChecked = checkedCheckboxes.length > 0;

                if (checkAllHeader) {
                    checkAllHeader.checked = allChecked;
                    checkAllHeader.indeterminate = someChecked && !allChecked;
                }

                if (checkAllOutside) {
                    checkAllOutside.checked = allChecked;
                    checkAllOutside.indeterminate = someChecked && !allChecked;
                }
            }

            // Validasi form sebelum submit
            document.getElementById('formKonfirmasiBanyak')?.addEventListener('submit', function(e) {
                e.preventDefault();

                const checkedBoxes = document.querySelectorAll('.absen-check:checked');
                if (checkedBoxes.length === 0) {
                    showAlert('warning', 'Silakan pilih minimal satu absensi untuk dikonfirmasi');
                    return false;
                }

                const formData = new FormData(this);
                const status = formData.get('status');

                if (!confirm(
                        `Apakah Anda yakin ingin ${status === 'disetujui' ? 'menyetujui' : 'menolak'} ${checkedBoxes.length} absensi yang dipilih?`
                    )) {
                    return false;
                }

                // Tampilkan loading
                const submitButtons = this.querySelectorAll('button[type="submit"]');
                submitButtons.forEach(btn => {
                    btn.disabled = true;
                    btn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
                });

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showAlert('success', data.message);

                            // Hapus baris yang berhasil diproses
                            checkedBoxes.forEach(checkbox => {
                                const row = checkbox.closest('tr');
                                if (row) {
                                    row.remove();
                                }
                            });

                            // Update badge counter
                            updatePendingCounter();

                            // Periksa apakah masih ada data
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

                            // Reset form
                            this.reset();
                            updateCheckAllState();
                        } else {
                            showAlert('error', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('error', 'Terjadi kesalahan koneksi: ' + error.message);
                    })
                    .finally(() => {
                        // Kembalikan tombol ke keadaan semula
                        submitButtons.forEach(btn => {
                            btn.disabled = false;
                            if (btn.name === 'status' && btn.value === 'disetujui') {
                                btn.innerHTML =
                                    '<i class="bi bi-check-lg"></i> Setujui yang Dipilih';
                            } else if (btn.name === 'status' && btn.value === 'ditolak') {
                                btn.innerHTML = '<i class="bi bi-x-lg"></i> Tolak yang Dipilih';
                            }
                        });
                    });
            });

            // Event delegation untuk tombol konfirmasi izin
            document.addEventListener('click', function(e) {
                // Cek apakah yang diklik adalah tombol konfirmasi izin
                if (e.target.closest('.btn-konfirmasi-izin')) {
                    e.preventDefault();
                    const button = e.target.closest('.btn-konfirmasi-izin');
                    const izinId = button.getAttribute('data-izin-id');
                    const status = button.getAttribute('data-status');

                    konfirmasiIzin(izinId, status);
                }
            });

            // Inisialisasi state awal
            updateCheckAllState();
        });




        // Fungsi untuk konfirmasi individual
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

            // Gunakan route yang benar
            fetch(`{{ route('iduka.konfirmasi-absen.proses', ['id' => ':id']) }}`.replace(':id', pendingId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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

        function konfirmasiDinas(dinasId, status) {
            console.log('konfirmasiDinas called:', dinasId, status);

            if (!dinasId) {
                console.error('dinasId is undefined');
                alert('ID dinas tidak ditemukan');
                return;
            }

            const actionText = status === 'disetujui' ? 'menyetujui' : 'menolak';

            if (!confirm(`Apakah Anda yakin ingin ${actionText} dinas luar ini?`)) {
                return;
            }

            let catatan = null;
            if (status === 'ditolak') {
                catatan = prompt('Masukkan alasan penolakan:');
                if (catatan === null) return;
                if (catatan.trim() === '') {
                    alert('Alasan penolakan harus diisi!');
                    return;
                }
            }

            // Show loading
            const row = document.querySelector(`tr[data-dinas-id="${dinasId}"]`);
            if (row) {
                row.style.opacity = '0.5';
                const buttons = row.querySelectorAll('button');
                buttons.forEach(btn => btn.disabled = true);
            }

            // Ambil CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                console.error('CSRF token not found');
                alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                if (row) {
                    row.style.opacity = '1';
                    const buttons = row.querySelectorAll('button');
                    buttons.forEach(btn => btn.disabled = false);
                }
                return;
            }

            // Coba beberapa URL yang mungkin
            const possibleUrls = [
                `{{ route('iduka.konfirmasi-dinas', ['id' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', dinasId),
                `/konfirmasi-dinas/${dinasId}`,
                `/iduka/konfirmasi-dinas/${dinasId}`
            ];

            console.log('Mencoba URL:', possibleUrls);

            // Coba setiap URL
            tryFetchUrl(possibleUrls[0], dinasId, status, catatan, row)
                .catch(() => tryFetchUrl(possibleUrls[1], dinasId, status, catatan, row))
                .catch(() => tryFetchUrl(possibleUrls[2], dinasId, status, catatan, row))
                .catch(error => {
                    console.error('Semua URL gagal:', error);
                    alert('Tidak dapat terhubung ke server. Silakan coba lagi.');
                    if (row) {
                        row.style.opacity = '1';
                        const buttons = row.querySelectorAll('button');
                        buttons.forEach(btn => btn.disabled = false);
                    }
                });
        }

        function tryFetchUrl(url, dinasId, status, catatan, row) {
            console.log('Mencoba URL:', url);

            return fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        status: status,
                        catatan: catatan
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);

                    if (data.success) {
                        alert(data.message);
                        if (row) row.remove();
                        updateDinasPendingCounter();

                        const tbody = document.querySelector('#v-pills-dinas-pending tbody');
                        if (tbody) {
                            const remainingRows = tbody.querySelectorAll('tr');
                            if (remainingRows.length === 0) {
                                tbody.innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Tidak ada dinas luar yang perlu dikonfirmasi
                            </td>
                        </tr>
                    `;
                            }
                        }
                    } else {
                        alert(data.message || 'Terjadi kesalahan');
                        if (row) {
                            row.style.opacity = '1';
                            const buttons = row.querySelectorAll('button');
                            buttons.forEach(btn => btn.disabled = false);
                        }
                    }
                });
        }

        // Update badge counter untuk dinas pending
        function updateDinasPendingCounter() {
            const badge = document.getElementById('badge-dinas-pending');
            if (badge) {
                const currentCount = parseInt(badge.textContent) || 0;
                const newCount = Math.max(0, currentCount - 1);
                badge.textContent = newCount;

                if (newCount === 0) {
                    badge.style.display = 'none';
                }
            }
        }

        // Event delegation untuk tombol konfirmasi dinas
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk tombol konfirmasi dinas
            document.addEventListener('click', function(e) {
                // Cek apakah yang diklik adalah tombol konfirmasi dinas
                if (e.target.closest('.btn-konfirmasi-dinas')) {
                    e.preventDefault();
                    const button = e.target.closest('.btn-konfirmasi-dinas');
                    const dinasId = button.getAttribute('data-dinas-id');
                    const status = button.getAttribute('data-status');

                    konfirmasiDinas(dinasId, status);
                }
            });
        });

        // Fungsi untuk menolak absensi
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

            // Gunakan route tolak-absen yang benar
            fetch(`{{ route('iduka.tolak-absen', ['id' => ':id']) }}`.replace(':id', pendingId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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

        // Fungsi untuk konfirmasi izin oleh IDUKA atau Guru
        function konfirmasiIzin(izinId, status) {
            console.log('konfirmasiIzin called:', izinId, status); // Debug

            if (!izinId) {
                console.error('izinId is undefined'); // Debug
                alert('ID izin tidak ditemukan');
                return;
            }

            const actionText = status === 'disetujui' ? 'menyetujui' : 'menolak';

            if (!confirm(`Apakah Anda yakin ingin ${actionText} izin ini?`)) {
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

                // Disable all buttons in the row
                const buttons = row.querySelectorAll('button');
                buttons.forEach(btn => {
                    btn.disabled = true;
                });
            }

            // Ambil CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                console.error('CSRF token not found'); // Debug
                alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                if (row) {
                    row.style.opacity = '1';
                    const buttons = row.querySelectorAll('button');
                    buttons.forEach(btn => {
                        btn.disabled = false;
                    });
                }
                return;
            }

            // Buat URL dengan route yang benar
            const url = `{{ route('iduka.konfirmasi-izin', ['id' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', izinId);
            console.log('Fetch URL:', url); // Debug

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        status: status,
                        catatan: catatan
                    })
                })
                .then(response => {
                    console.log('Fetch response status:', response.status); // Debug
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data); // Debug

                    if (data.success) {
                        // Tampilkan pesan sukses
                        alert(data.message);

                        // Hapus baris dari tabel
                        if (row) {
                            row.remove();
                        }

                        // Update badge counter
                        updateIzinPendingCounter();

                        // Periksa apakah masih ada data
                        const tbody = document.querySelector('#v-pills-perlu-konfirmasi tbody');
                        if (tbody) {
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
                        }
                    } else {
                        // Tampilkan pesan error
                        alert(data.message || 'Terjadi kesalahan');

                        // Kembalikan state row
                        if (row) {
                            row.style.opacity = '1';
                            const buttons = row.querySelectorAll('button');
                            buttons.forEach(btn => {
                                btn.disabled = false;
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error); // Debug
                    alert('Terjadi kesalahan koneksi: ' + error.message);

                    // Kembalikan state row
                    if (row) {
                        row.style.opacity = '1';
                        const buttons = row.querySelectorAll('button');
                        buttons.forEach(btn => {
                            btn.disabled = false;
                        });
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

        // Fungsi untuk menampilkan alert
        function showAlert(type, message) {
            // Hapus alert sebelumnya
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => {
                if (alert.classList.contains('alert-success') ||
                    alert.classList.contains('alert-danger') ||
                    alert.classList.contains('alert-warning')) {
                    alert.remove();
                }
            });

            // Buat alert baru
            const alertClass = type === 'success' ? 'alert-success' :
                type === 'error' ? 'alert-danger' : 'alert-warning';
            const iconClass = type === 'success' ? 'bi-check-circle' :
                type === 'error' ? 'bi-exclamation-triangle' : 'bi-info-circle';

            const alertDiv = document.createElement('div');
            alertDiv.className = `alert ${alertClass} alert-dismissible fade show`;
            alertDiv.innerHTML = `
    <i class="${iconClass} me-2"></i>
    <strong>${type === 'success' ? 'Berhasil!' : type === 'error' ? 'Error!' : 'Peringatan!'}</strong> ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
`;

            // Sisipkan di bagian atas container
            const container = document.querySelector('.container-xxl');
            if (container) {
                container.insertBefore(alertDiv, container.firstChild);
            }

            // Auto hide setelah 3 detik
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 3000);
        }
    </script>

    <style>
        /* Perbaiki tampilan checkbox */
        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            margin-top: 0.3em;
            cursor: pointer;
        }

        /* Beri efek hover pada baris tabel */
        tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        /* Perbesar area klik untuk checkbox di header */
        th:first-child {
            cursor: pointer;
        }

        /* Animasi untuk checkbox */
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        /* Style untuk indeterminate state */
        .form-check-input:indeterminate {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        /* Loading spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').each(function() {
                $(this).select2({
                    dropdownParent: $(this).closest('.modal').length ? $(this).closest('.modal') :
                        $(this).parent(),
                    placeholder: "-- Pilih IDUKA --",
                    allowClear: true,
                    width: '100%',
                    dropdownPosition: 'below'
                });
            });
        });
    </script>
@endpush
