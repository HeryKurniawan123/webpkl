@extends('layout.main')

@section('content')
    <div class="container-fluid"><br>
        {{-- Flash Messages --}}
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Peringatan!</strong> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Informasi:</strong> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Validasi Error!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y mb-6">

                {{-- Welcome Card --}}
                <div class="row">
                    <div class="col-lg-12 mb-3 order-0">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Selamat Datang di Sistem Absensi! 👋</h5>
                                        <p class="mb-4">Jangan lupa untuk melakukan absensi setiap hari. Pastikan Anda
                                            berada di lokasi IDUKA yang benar.</p>
                                        @auth
                                            @if (Auth::user()->idukaDiterima)
                                                <div class="alert alert-info mt-3">
                                                    <strong>IDUKA Anda:</strong> {{ Auth::user()->idukaDiterima->nama }}<br>
                                                    <strong>Lokasi:</strong> {{ Auth::user()->idukaDiterima->alamat }}<br>
                                                    <strong>Radius:</strong>
                                                    {{ Auth::user()->idukaDiterima->radius ?? 'Belum diatur' }} meter<br>
                                                    <strong>Jam Masuk:</strong>
                                                    {{ Auth::user()->idukaDiterima->jam_masuk
                                                        ? date('H:i', strtotime(Auth::user()->idukaDiterima->jam_masuk))
                                                        : '08:00 (default)' }}

                                                    <strong>Jam Pulang:</strong>
                                                    {{ Auth::user()->idukaDiterima->jam_pulang
                                                        ? date('H:i', strtotime(Auth::user()->idukaDiterima->jam_pulang))
                                                        : '15:00 (default)' }}

                                                </div>
                                            @else
                                                <div class="alert alert-warning">
                                                    Anda belum terdaftar di IDUKA manapun. Silakan hubungi administrator.
                                                </div>
                                            @endif
                                        @endauth
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

                {{-- Status Absensi Hari Ini --}}
                @if ($absensiHariIni)
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card border-success">
                                <div class="card-header bg-light-success">
                                    <h5 class="card-title text-success mb-0">
                                        <i class="bi bi-check-circle me-2"></i>Status Absensi Hari Ini
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if ($absensiHariIni->status === 'izin')
                                            <div class="col-12">
                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    <strong>Anda sedang izin hari ini</strong><br>
                                                    Alasan: {{ $absensiHariIni->keterangan_izin }}<br>
                                                    Waktu pengajuan: {{ $absensiHariIni->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        @elseif ($absensiHariIni->status_dinas === 'disetujui')
                                            <div class="col-12">
                                                <div class="alert alert-primary">
                                                    <i class="bi bi-briefcase me-2"></i>
                                                    <strong>Anda sedang dinas luar hari ini</strong><br>
                                                    Jenis:
                                                    {{ ucfirst(str_replace('_', ' ', $absensiHariIni->jenis_dinas)) }}<br>
                                                    Alasan: {{ $absensiHariIni->keterangan_dinas }}<br>
                                                    <small class="text-muted">Anda bisa langsung absen pulang tanpa harus
                                                        absen masuk terlebih dahulu</small>
                                                </div>
                                            </div>
                                        @else
                                            @if ($absensiHariIni->jam_masuk)
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="flex-shrink-0">
                                                            <i class="bi bi-clock text-success"
                                                                style="font-size: 24px;"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="mb-1">Absen Masuk</h6>
                                                            <p class="mb-0 text-success">
                                                                {{ $absensiHariIni->jam_masuk->format('H:i') }}</p>
                                                            <small class="text-muted">
                                                                Status:
                                                                @if ($absensiHariIni->status === 'tepat_waktu')
                                                                    <span class="badge bg-success">Tepat Waktu</span>
                                                                @else
                                                                    <span class="badge bg-warning">Terlambat</span>
                                                                @endif
                                                                @if ($absensiHariIni->status_dinas === 'disetujui')
                                                                    <span class="badge bg-primary ms-1">Dinas Luar</span>
                                                                @endif
                                                                <span class="text-muted ms-2">
                                                                    Batas:
                                                                    {{ Auth::user()->idukaDiterima->jam_masuk ? Auth::user()->idukaDiterima->jam_masuk->format('H:i') : '08:00' }}
                                                                </span>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($absensiHariIni->jam_pulang)
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="flex-shrink-0">
                                                            <i class="bi bi-clock-history text-warning"
                                                                style="font-size: 24px;"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="mb-1">Absen Pulang</h6>
                                                            <p class="mb-0 text-warning">
                                                                {{ $absensiHariIni->jam_pulang->format('H:i') }}</p>
                                                            <small class="text-muted">
                                                                @if ($absensiHariIni->status_dinas === 'disetujui')
                                                                    <span class="badge bg-primary">Dinas Luar</span>
                                                                @endif
                                                                Minimal:
                                                                {{ Auth::user()->idukaDiterima->jam_pulang ? Auth::user()->idukaDiterima->jam_pulang->format('H:i') : '15:00' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Tombol Absensi, Izin, dan Dinas Luar --}}
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Absensi Hari Ini</h5>
                                <small class="text-muted">Pastikan GPS aktif dan Anda berada dalam radius IDUKA</small>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="locationSwitch"
                                        {{ $absensiHariIni && ($absensiHariIni->status === 'izin' || ($absensiHariIni->jam_masuk && $absensiHariIni->jam_pulang)) ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="locationSwitch">Akses Lokasi</label>
                                </div>
                                <small id="locationStatus" class="text-muted">
                                    @if ($absensiHariIni && $absensiHariIni->status === 'izin')
                                        Anda sedang izin hari ini
                                    @elseif ($absensiHariIni && $absensiHariIni->status_dinas === 'disetujui')
                                        Anda sedang dinas luar hari ini - wajib absensi masuk dan pulang
                                    @elseif ($absensiHariIni && $absensiHariIni->jam_masuk && $absensiHariIni->jam_pulang)
                                        Absensi hari ini sudah lengkap
                                    @else
                                        Menunggu akses lokasi...
                                    @endif
                                </small>
                            </div>
                            <div class="card-body">
                                {{-- Debug Info --}}
                                @auth
                                    @if (Auth::user()->idukaDiterima)
                                        <div class="alert alert-secondary mb-3">
                                            <h6>Debug Info:</h6>
                                            <p>IDUKA Latitude: {{ Auth::user()->idukaDiterima->latitude ?? 'Tidak diatur' }}
                                            </p>
                                            <p>IDUKA Longitude: {{ Auth::user()->idukaDiterima->longitude ?? 'Tidak diatur' }}
                                            </p>
                                            <p>Radius: {{ Auth::user()->idukaDiterima->radius ?? 'Tidak diatur' }} meter</p>
                                            <p>Jam Masuk:
                                                {{ Auth::user()->idukaDiterima->jam_masuk ? Auth::user()->idukaDiterima->jam_masuk->format('H:i') : '08:00 (default)' }}
                                            </p>
                                            <p>Jam Pulang:
                                                {{ Auth::user()->idukaDiterima->jam_pulang ? Auth::user()->idukaDiterima->jam_pulang->format('H:i') : '15:00 (default)' }}
                                            </p>
                                        </div>
                                    @endif
                                @endauth

                                <div class="row g-3">

                                    {{-- Tombol Absen Masuk --}}
                                    <div class="col-md-3 col-6">
                                        <form method="POST" action="{{ route('absensi.masuk') }}" id="formMasuk">
                                            @csrf
                                            <input type="hidden" name="latitude" id="latitudeMasuk">
                                            <input type="hidden" name="longitude" id="longitudeMasuk">

                                            <button type="submit" class="btn btn-success w-100 h-100 py-4"
                                                id="btnMasuk"
                                                {{ $absensiHariIni && ($absensiHariIni->jam_masuk || $absensiHariIni->status === 'izin' || $absensiHariIni->status === 'dinas') ? 'disabled' : '' }}>
                                                <i class="bi bi-clock me-2 fs-4"></i><br>
                                                <strong>Absen Masuk</strong><br>
                                                <small>
                                                    @if ($absensiHariIni && $absensiHariIni->jam_masuk)
                                                        Sudah absen: {{ $absensiHariIni->jam_masuk->format('H:i') }}
                                                    @elseif ($absensiHariIni && ($absensiHariIni->status === 'izin' || $absensiHariIni->status === 'dinas'))
                                                        Sedang
                                                        {{ $absensiHariIni->status === 'izin' ? 'izin' : 'dinas luar' }}
                                                    @else
                                                        Klik untuk absen masuk
                                                    @endif
                                                </small>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Tombol Absen Pulang --}}
                                    <div class="col-md-3 col-6">
                                        <form method="POST" action="{{ route('absensi.pulang.siswa') }}"
                                            id="formPulang">
                                            @csrf
                                            <input type="hidden" name="latitude" id="latitudePulang">
                                            <input type="hidden" name="longitude" id="longitudePulang">

                                            <button type="submit" class="btn btn-warning w-100 h-100 py-4"
                                                id="btnPulang"
                                                {{ !$absensiHariIni || !$absensiHariIni->jam_masuk || $absensiHariIni->jam_pulang || $absensiHariIni->status === 'izin' || $absensiHariIni->status === 'dinas' ? 'disabled' : '' }}>
                                                <i class="bi bi-clock-history me-2 fs-4"></i><br>
                                                <strong>Absen Pulang</strong><br>
                                                <small>
                                                    @if ($absensiHariIni && $absensiHariIni->jam_pulang)
                                                        Sudah absen: {{ $absensiHariIni->jam_pulang->format('H:i') }}
                                                    @elseif ($absensiHariIni && ($absensiHariIni->status === 'izin' || $absensiHariIni->status === 'dinas'))
                                                        Sedang
                                                        {{ $absensiHariIni->status === 'izin' ? 'izin' : 'dinas luar' }}
                                                    @elseif (!$absensiHariIni || !$absensiHariIni->jam_masuk)
                                                        Absen masuk dulu
                                                    @else
                                                        Klik untuk absen pulang
                                                    @endif
                                                </small>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Tombol Izin --}}
                                    <div class="col-md-3 col-6">
                                        <button type="button" class="btn btn-info w-100 h-100 py-4" id="btnIzin"
                                            data-bs-toggle="modal" data-bs-target="#modalIzin"
                                            {{ $absensiHariIni ? 'disabled' : '' }}>
                                            <i class="bi bi-file-earmark-text me-2 fs-4"></i><br>
                                            <strong>Izin</strong><br>
                                            <small>
                                                @if ($absensiHariIni && $absensiHariIni->status === 'izin')
                                                    Sudah izin
                                                @elseif ($absensiHariIni)
                                                    Ada absensi
                                                @else
                                                    Tidak masuk
                                                @endif
                                            </small>
                                        </button>
                                    </div>

                                    {{-- Tombol Dinas Luar --}}
                                    <div class="col-md-3 col-6">
                                        <button type="button" class="btn btn-primary w-100 h-100 py-4" id="btnDinas"
                                            data-bs-toggle="modal" data-bs-target="#modalDinas"
                                            {{ $absensiHariIni ? 'disabled' : '' }}>
                                            <i class="bi bi-briefcase me-2 fs-4"></i><br>
                                            <strong>Dinas Luar</strong><br>
                                            <small>
                                                @if ($absensiHariIni && $absensiHariIni->status === 'dinas')
                                                    Sedang dinas
                                                @elseif ($absensiHariIni)
                                                    Ada absensi
                                                @else
                                                    Tugas luar
                                                @endif
                                            </small>
                                        </button>
                                    </div>

                                </div>


                                {{-- Info Lokasi --}}
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading mb-2">Info Lokasi:</h6>
                                            <div id="locationInfo">
                                                @auth
                                                    @if (Auth::user()->idukaDiterima)
                                                        <p>Lokasi IDUKA:
                                                            {{ Auth::user()->idukaDiterima->latitude ?? 'Tidak diatur' }},
                                                            {{ Auth::user()->idukaDiterima->longitude ?? 'Tidak diatur' }}</p>
                                                        <p>Radius yang diizinkan:
                                                            {{ Auth::user()->idukaDiterima->radius ?? 'Tidak diatur' }} meter
                                                        </p>
                                                    @endif
                                                @endauth
                                                <p>Status: <span id="distanceStatus">Menunggu akses lokasi</span></p>
                                                <p>Jarak: <span id="distanceValue">-</span></p>
                                                <p>Lokasi Anda: <span id="userLocation">-</span></p>
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

    {{-- Modal Izin --}}
    <div class="modal fade" id="modalIzin" tabindex="-1" aria-labelledby="modalIzinLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalIzinLabel">Ajukan Izin Tidak Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('absensi.izin') }}" id="formIzin">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jenisIzin" class="form-label">Jenis Izin</label>
                            <select class="form-select" id="jenisIzin" name="jenis_izin" required>
                                <option value="">Pilih jenis izin</option>
                                <option value="sakit">Sakit</option>
                                <option value="keperluan_keluarga">Keperluan Keluarga</option>
                                <option value="keperluan_sekolah">Keperluan Sekolah</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keteranganIzin" class="form-label">Keterangan/Alasan</label>
                            <textarea class="form-control" id="keteranganIzin" name="keterangan" rows="3"
                                placeholder="Jelaskan alasan izin Anda..." required></textarea>
                            <div class="form-text">Minimal 10 karakter, maksimal 500 karakter</div>
                        </div>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Setelah mengajukan izin, Anda tidak bisa melakukan absensi
                            masuk/pulang hari ini.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Ajukan Izin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Dinas Luar --}}
    <div class="modal fade" id="modalDinas" tabindex="-1" aria-labelledby="modalDinasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDinasLabel">Ajukan Dinas Luar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('absensi.dinas-luar') }}" id="formDinas">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jenisDinas" class="form-label">Jenis Dinas</label>
                            <select class="form-select" id="jenisDinas" name="jenis_dinas" required>
                                <option value="">Pilih jenis dinas</option>
                                <option value="perusahaan">Perusahaan</option>
                                <option value="sekolah">Sekolah</option>
                                <option value="instansi_pemerintah">Instansi Pemerintah</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keteranganDinas" class="form-label">Keterangan/Alasan</label>
                            <textarea class="form-control" id="keteranganDinas" name="keterangan" rows="3"
                                placeholder="Jelaskan alasan dinas luar Anda..." required></textarea>
                            <div class="form-text">Minimal 10 karakter, maksimal 500 karakter</div>
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Informasi:</strong> Setelah mengajukan dinas luar dan disetujui, Anda tetap wajib
                            melakukan absensi masuk dan pulang seperti biasa.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ajukan Dinas Luar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .izin-status-alert,
        .dinas-status-alert {
            margin-bottom: 1rem;
        }
    </style>

    <script>
        // Variabel global untuk menyimpan posisi
        let currentPosition = null;
        let watchId = null;

        // Status absensi hari ini dari server
        const absensiHariIni = @json($absensiHariIni);
        const sudahAbsenMasuk = absensiHariIni && absensiHariIni.jam_masuk;
        const sudahAbsenPulang = absensiHariIni && absensiHariIni.jam_pulang;
        const sedangIzin = absensiHariIni && absensiHariIni.status === 'izin';
        const sedangDinas = absensiHariIni && absensiHariIni.status_dinas === 'disetujui';

        // Elemen UI
        const locationSwitch = document.getElementById('locationSwitch');
        const locationStatus = document.getElementById('locationStatus');
        const distanceStatus = document.getElementById('distanceStatus');
        const distanceValue = document.getElementById('distanceValue');
        const userLocation = document.getElementById('userLocation');
        const btnMasuk = document.getElementById('btnMasuk');
        const btnPulang = document.getElementById('btnPulang');
        const btnIzin = document.getElementById('btnIzin');
        const btnDinas = document.getElementById('btnDinas');
        const latitudeMasuk = document.getElementById('latitudeMasuk');
        const longitudeMasuk = document.getElementById('longitudeMasuk');
        const latitudePulang = document.getElementById('latitudePulang');
        const longitudePulang = document.getElementById('longitudePulang');

        // Koordinat IDUKA dari user yang login
        @auth
        @if (Auth::user()->idukaDiterima && Auth::user()->idukaDiterima->latitude && Auth::user()->idukaDiterima->longitude)
            const idukaLat = {{ Auth::user()->idukaDiterima->latitude }};
            const idukaLng = {{ Auth::user()->idukaDiterima->longitude }};
            const allowedRadius = {{ Auth::user()->idukaDiterima->radius ?? 100 }};
            const hasValidIduka = true;
            // Ambil jam operasional dari IDUKA
            const jamMasukIduka =
                "{{ Auth::user()->idukaDiterima->jam_masuk ? Auth::user()->idukaDiterima->jam_masuk->format('H:i') : '08:00' }}";
            const jamPulangIduka =
                "{{ Auth::user()->idukaDiterima->jam_pulang ? Auth::user()->idukaDiterima->jam_pulang->format('H:i') : '15:00' }}";
        @else
            const idukaLat = null;
            const idukaLng = null;
            const allowedRadius = 100;
            const hasValidIduka = false;
            const jamMasukIduka = "08:00";
            const jamPulangIduka = "15:00";
        @endif
        @else
            const idukaLat = null;
            const idukaLng = null;
            const allowedRadius = 100;
            const hasValidIduka = false;
            const jamMasukIduka = "08:00";
            const jamPulangIduka = "15:00";
        @endauth

        // Fungsi untuk menghitung jarak antara dua titik (Haversine formula)
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371000; // Radius bumi dalam meter
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c; // Jarak dalam meter
            return distance;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        // Fungsi untuk validasi jam pulang
        function validateJamPulang() {
            const now = new Date();
            const [jam, menit] = jamPulangIduka.split(':');
            const jamPulangDate = new Date();
            jamPulangDate.setHours(parseInt(jam), parseInt(menit), 0, 0);

            // Jika sedang dinas luar, skip validasi jam
            if (sedangDinas) {
                return {
                    valid: true,
                    message: ''
                };
            }

            if (now < jamPulangDate) {
                return {
                    valid: false,
                    message: `Belum waktunya absen pulang. Absen pulang dibuka pukul ${jamPulangIduka}.`
                };
            }

            return {
                valid: true,
                message: ''
            };
        }

        function getLocation() {
            // Jika sudah lengkap absensi atau sedang izin, jangan ambil lokasi
            if ((sudahAbsenMasuk && sudahAbsenPulang) || sedangIzin) {
                locationStatus.textContent = sedangIzin ? "Sedang izin hari ini" : "Absensi hari ini sudah lengkap";
                return;
            }

            // Jika sedang dinas luar, tetap ambil lokasi untuk absensi pulang
            if (navigator.geolocation) {
                locationStatus.textContent = sedangDinas ? "Sedang dinas luar, siap untuk absen pulang..." :
                    "Mengambil lokasi...";

                // Dapatkan posisi sekali
                navigator.geolocation.getCurrentPosition(
                    showPosition,
                    showError, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );

                // Mulai pantau posisi
                watchId = navigator.geolocation.watchPosition(
                    watchPosition,
                    showError, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                locationStatus.textContent = "Geolocation tidak didukung oleh browser ini.";
            }
        }

        // Fungsi untuk menangani perubahan posisi (watch)
        function watchPosition(position) {
            currentPosition = position;
            updateLocationInfo(position);
        }

        // Fungsi untuk menangani posisi (single)
        function showPosition(position) {
            currentPosition = position;
            updateLocationInfo(position);
        }

        // Update info lokasi di UI
        function updateLocationInfo(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            const accuracy = position.coords.accuracy;

            // Update lokasi user
            userLocation.textContent = userLat.toFixed(6) + ", " + userLng.toFixed(6);
            locationStatus.textContent = "Lokasi terdeteksi dengan akurasi ±" + Math.round(accuracy) + "m";

            // Cek apakah IDUKA valid
            if (!hasValidIduka || idukaLat === null || idukaLng === null) {
                distanceStatus.textContent = "Koordinat IDUKA belum diatur";
                distanceStatus.className = "text-warning";
                distanceValue.textContent = "Tidak dapat menghitung jarak";

                // Disable tombol jika tidak ada IDUKA yang valid
                if (!sudahAbsenMasuk && !sedangIzin) btnMasuk.disabled = true;
                if (!sudahAbsenPulang && !sedangIzin && sudahAbsenMasuk) btnPulang.disabled = true;
                return;
            }

            // Hitung jarak ke IDUKA
            const distance = calculateDistance(userLat, userLng, idukaLat, idukaLng);

            // Update UI
            distanceValue.textContent = Math.round(distance) + " meter (akurasi: ±" + Math.round(accuracy) + "m)";

            // Cek apakah dalam radius (tambahkan toleransi akurasi)
            const toleranceRadius = allowedRadius + accuracy;
            const isWithinRadius = distance <= toleranceRadius;

            if (isWithinRadius) {
                distanceStatus.textContent = "✅ Anda berada dalam radius yang diizinkan";
                distanceStatus.className = "text-success";

                // Enable tombol sesuai kondisi
                if (!sudahAbsenMasuk && !sedangIzin) {
                    btnMasuk.disabled = false;
                }
                if (sudahAbsenMasuk && !sudahAbsenPulang && !sedangIzin) {
                    // Cek validasi jam pulang
                    const jamValidation = validateJamPulang();
                    btnPulang.disabled = !jamValidation.valid;
                    if (!jamValidation.valid) {
                        btnPulang.title = jamValidation.message;
                    } else {
                        btnPulang.title = "";
                    }
                }
            } else {
                distanceStatus.textContent = "❌ Anda berada di luar radius yang diizinkan";
                distanceStatus.className = "text-danger";

                // Disable tombol jika di luar radius
                if (!sudahAbsenMasuk && !sedangIzin) btnMasuk.disabled = true;
                if (!sudahAbsenPulang && !sedangIzin) btnPulang.disabled = true;
            }

            // Isi form dengan koordinat
            if (latitudeMasuk) latitudeMasuk.value = userLat;
            if (longitudeMasuk) longitudeMasuk.value = userLng;
            if (latitudePulang) latitudePulang.value = userLat;
            if (longitudePulang) longitudePulang.value = userLng;
        }

        // Fungsi untuk menangani error geolocation
        function showError(error) {
            let errorMessage = "";
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = "Pengguna menolak permintaan geolocation.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = "Informasi lokasi tidak tersedia.";
                    break;
                case error.TIMEOUT:
                    errorMessage = "Permintaan lokasi sudah timeout.";
                    break;
                case error.UNKNOWN_ERROR:
                    errorMessage = "Error tidak diketahui: " + error.message;
                    break;
            }

            locationStatus.textContent = errorMessage;
            distanceStatus.textContent = "Error lokasi";
            distanceValue.textContent = "-";
            userLocation.textContent = "-";

            // Disable tombol saat ada error lokasi
            if (!sudahAbsenMasuk && !sedangIzin) btnMasuk.disabled = true;
            if (!sudahAbsenPulang && !sedangIzin) btnPulang.disabled = true;
        }

        // Event listener untuk switch lokasi
        locationSwitch.addEventListener('change', function() {
            if (this.checked) {
                getLocation();
            } else {
                // Hentikan pemantauan lokasi
                if (watchId !== null) {
                    navigator.geolocation.clearWatch(watchId);
                    watchId = null;
                }

                locationStatus.textContent = "Akses lokasi dimatikan";
                distanceStatus.textContent = "Akses lokasi dimatikan";
                distanceValue.textContent = "-";
                userLocation.textContent = "-";

                // Disable tombol saat lokasi dimatikan
                if (!sudahAbsenMasuk && !sedangIzin) btnMasuk.disabled = true;
                if (!sudahAbsenPulang && !sedangIzin) btnPulang.disabled = true;
            }
        });

        // Validasi form absen masuk
        document.getElementById('formMasuk').addEventListener('submit', function(e) {
            if (sudahAbsenMasuk || sedangIzin) {
                e.preventDefault();
                alert(sedangIzin ? 'Anda sedang izin hari ini.' : 'Anda sudah melakukan absen masuk hari ini.');
                return false;
            }

            // Periksa apakah sedang dinas luar
            if (sedangDinas) {
                // Izinkan absen masuk meskipun sedang dinas luar
                console.log('Siswa sedang dinas luar, tetap diizinkan absen masuk');
            }

            if (!currentPosition) {
                e.preventDefault();
                alert('Lokasi tidak terdeteksi. Silakan aktifkan akses lokasi.');
                return false;
            }

            if (!hasValidIduka) {
                e.preventDefault();
                alert('Koordinat IDUKA belum diatur. Silakan hubungi administrator.');
                return false;
            }

            const userLat = currentPosition.coords.latitude;
            const userLng = currentPosition.coords.longitude;
            const accuracy = currentPosition.coords.accuracy;
            const distance = calculateDistance(userLat, userLng, idukaLat, idukaLng);

            if (distance > (allowedRadius + accuracy)) {
                e.preventDefault();
                alert(
                    `Anda berada di luar radius yang diizinkan untuk absensi.\nJarak Anda: ${Math.round(distance)} meter\nRadius maksimal: ${allowedRadius} meter`
                );
                return false;
            }
        });

        // Validasi form absen pulang
        document.getElementById('formPulang').addEventListener('submit', function(e) {
            const absensiHariIni = @json($absensiHariIni);
            const sedangDinas = absensiHariIni && absensiHariIni.status_dinas === 'disetujui';

            // Validasi jam pulang
            const jamValidation = validateJamPulang();
            if (!jamValidation.valid) {
                e.preventDefault();
                alert(jamValidation.message);
                return false;
            }

            // Kalau sedang dinas luar, skip pengecekan absen masuk
            if (sedangDinas) {
                console.log('Siswa sedang dinas luar, langsung diizinkan absen pulang tanpa absen masuk');
            } else {
                // Hanya berlaku kalau BUKAN dinas
                if (!sudahAbsenMasuk) {
                    e.preventDefault();
                    alert('Anda belum melakukan absen masuk hari ini.');
                    return false;
                }

                if (sudahAbsenPulang || sedangIzin) {
                    e.preventDefault();
                    alert(sedangIzin ? 'Anda sedang izin hari ini.' :
                        'Anda sudah melakukan absen pulang hari ini.');
                    return false;
                }
            }

            if (!currentPosition) {
                e.preventDefault();
                alert('Lokasi tidak terdeteksi. Silakan aktifkan akses lokasi.');
                return false;
            }

            if (!hasValidIduka) {
                e.preventDefault();
                alert('Koordinat IDUKA belum diatur. Silakan hubungi administrator.');
                return false;
            }

            const userLat = currentPosition.coords.latitude;
            const userLng = currentPosition.coords.longitude;
            const accuracy = currentPosition.coords.accuracy;
            const distance = calculateDistance(userLat, userLng, idukaLat, idukaLng);

            if (distance > (allowedRadius + accuracy)) {
                e.preventDefault();
                alert(
                    `Anda berada di luar radius yang diizinkan untuk absensi.\nJarak Anda: ${Math.round(distance)} meter\nRadius maksimal: ${allowedRadius} meter`
                );
                return false;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const formIzin = document.getElementById('formIzin');
            const formDinas = document.getElementById('formDinas');
            const modalIzin = new bootstrap.Modal(document.getElementById('modalIzin'));
            const modalDinas = new bootstrap.Modal(document.getElementById('modalDinas'));
            let absensiHariIni = false; // Variabel untuk menyimpan status absensi

            // Cek status izin saat modal dibuka
            document.getElementById('modalIzin').addEventListener('show.bs.modal', function() {
                cekStatusIzin();
            });

            // Cek status dinas saat modal dibuka
            document.getElementById('modalDinas').addEventListener('show.bs.modal', function() {
                cekStatusDinas();
            });

            // Fungsi untuk cek status izin
            function cekStatusIzin() {
                fetch('{{ route('absensi.cek-izin') }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update variabel absensiHariIni
                        absensiHariIni = data.has_attendance || data.has_approved_izin;

                        if (data.has_attendance) {
                            // Jika sudah ada absensi
                            disableIzinForm(
                                'Anda sudah memiliki record absensi hari ini. Tidak bisa mengajukan izin.');
                        } else if (data.has_approved_izin) {
                            // Jika sudah ada izin disetujui
                            disableIzinForm('Anda sudah mengajukan izin hari ini.');
                        } else if (data.has_pending_izin) {
                            // Jika ada izin pending
                            disableIzinForm('Anda sudah mengajukan izin. Menunggu konfirmasi IDUKA.');
                        } else {
                            // Jika tidak ada izin, enable form
                            enableIzinForm();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            // Fungsi untuk cek status dinas
            function cekStatusDinas() {
                fetch('{{ route('absensi.cek-dinas') }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update variabel absensiHariIni
                        absensiHariIni = data.has_attendance || data.has_approved_dinas;

                        if (data.has_attendance) {
                            // Jika sudah ada absensi
                            disableDinasForm(
                                'Anda sudah memiliki record absensi hari ini. Tidak bisa mengajukan dinas luar.'
                            );
                        } else if (data.has_approved_dinas) {
                            // Jika sudah ada dinas disetujui
                            disableDinasForm('Anda sudah mengajukan dinas luar hari ini.');
                        } else if (data.has_pending_dinas) {
                            // Jika ada dinas pending
                            disableDinasForm('Anda sudah mengajukan dinas luar. Menunggu konfirmasi IDUKA.');
                        } else {
                            // Jika tidak ada dinas, enable form
                            enableDinasForm();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            function disableIzinForm(message) {
                // Nonaktifkan form
                formIzin.querySelectorAll('select, textarea, button[type="submit"]').forEach(el => {
                    el.disabled = true;
                });

                // Tampilkan pesan
                let alertDiv = formIzin.querySelector('.izin-status-alert');
                if (!alertDiv) {
                    alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-info mt-3 izin-status-alert';
                    formIzin.querySelector('.modal-body').appendChild(alertDiv);
                }
                alertDiv.innerHTML = `<i class="bi bi-info-circle me-2"></i> ${message}`;
            }

            function enableIzinForm() {
                // Aktifkan form
                formIzin.querySelectorAll('select, textarea, button[type="submit"]').forEach(el => {
                    el.disabled = false;
                });

                // Hapus pesan alert jika ada
                const alertDiv = formIzin.querySelector('.izin-status-alert');
                if (alertDiv) {
                    alertDiv.remove();
                }
            }

            function disableDinasForm(message) {
                // Nonaktifkan form
                formDinas.querySelectorAll('select, textarea, button[type="submit"]').forEach(el => {
                    el.disabled = true;
                });

                // Tampilkan pesan
                let alertDiv = formDinas.querySelector('.dinas-status-alert');
                if (!alertDiv) {
                    alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-info mt-3 dinas-status-alert';
                    formDinas.querySelector('.modal-body').appendChild(alertDiv);
                }
                alertDiv.innerHTML = `<i class="bi bi-info-circle me-2"></i> ${message}`;
            }

            function enableDinasForm() {
                // Aktifkan form
                formDinas.querySelectorAll('select, textarea, button[type="submit"]').forEach(el => {
                    el.disabled = false;
                });

                // Hapus pesan alert jika ada
                const alertDiv = formDinas.querySelector('.dinas-status-alert');
                if (alertDiv) {
                    alertDiv.remove();
                }
            }

            // Validasi form izin
            document.getElementById('formIzin').addEventListener('submit', function(e) {
                // Cek jika sudah ada absensi (dari hasil fetch sebelumnya)
                if (absensiHariIni) {
                    e.preventDefault();
                    alert('Anda sudah memiliki record absensi hari ini. Tidak bisa mengajukan izin.');
                    return false;
                }

                // Validasi keterangan
                const keterangan = document.getElementById('keteranganIzin').value.trim();
                if (keterangan.length < 10) {
                    e.preventDefault();
                    alert('Keterangan izin minimal 10 karakter.');
                    return false;
                }

                // Konfirmasi pengajuan izin
                if (!confirm(
                        'Apakah Anda yakin ingin mengajukan izin? Setelah izin diajukan, Anda tidak bisa melakukan absensi hari ini.'
                    )) {
                    e.preventDefault();
                    return false;
                }
            });

            // Validasi form dinas
            document.getElementById('formDinas').addEventListener('submit', function(e) {
                // Cek jika sudah ada absensi (dari hasil fetch sebelumnya)
                if (absensiHariIni) {
                    e.preventDefault();
                    alert('Anda sudah memiliki record absensi hari ini. Tidak bisa mengajukan dinas luar.');
                    return false;
                }

                // Validasi keterangan
                const keterangan = document.getElementById('keteranganDinas').value.trim();
                if (keterangan.length < 10) {
                    e.preventDefault();
                    alert('Keterangan dinas minimal 10 karakter.');
                    return false;
                }

                // Konfirmasi pengajuan dinas
                if (!confirm(
                        'Apakah Anda yakin ingin mengajukan dinas luar? Setelah dinas diajukan dan disetujui, Anda tetap wajib melakukan absensi masuk dan pulang seperti biasa.'
                    )) {
                    e.preventDefault();
                    return false;
                }
            });

            // Fungsi untuk update status tombol berdasarkan waktu
            function updateButtonStatusBasedOnTime() {
                // Update status tombol pulang jika sudah absen masuk
                if (sudahAbsenMasuk && !sudahAbsenPulang && !sedangIzin && !sedangDinas) {
                    const jamValidation = validateJamPulang();
                    btnPulang.disabled = !jamValidation.valid || !locationSwitch.checked;
                    btnPulang.title = jamValidation.valid ? "" : jamValidation.message;

                    // Update teks pada tombol jika perlu
                    const smallText = btnPulang.querySelector('small');
                    if (smallText && !jamValidation.valid) {
                        smallText.textContent = `Belum waktunya (absen pulang dapat dilakukan  ${jamPulangIduka})`;
                    } else if (smallText && jamValidation.valid) {
                        smallText.textContent = 'Klik untuk absen pulang';
                    }
                }
            }

            // Panggil fungsi update status tombol
            updateButtonStatusBasedOnTime();

            // Set interval untuk update status tombol setiap menit
            setInterval(updateButtonStatusBasedOnTime, 60000);
        });

        // Auto-check jika tidak ada IDUKA yang valid
        document.addEventListener('DOMContentLoaded', function() {
            if (!hasValidIduka) {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger mt-3';
                alertDiv.innerHTML =
                    '<strong>Peringatan:</strong> Koordinat IDUKA belum diatur. Silakan hubungi administrator untuk mengatur koordinat IDUKA.';
                document.querySelector('.card-body').prepend(alertDiv);
            }

            // Disable switch jika sudah lengkap atau izin
            if ((sudahAbsenMasuk && sudahAbsenPulang) || sedangIzin) {
                locationSwitch.disabled = true;
            }
        });

        function updateButtonStates() {
            // Status dari server
            const absensiHariIni = @json($absensiHariIni);
            const sedangDinas = absensiHariIni && absensiHariIni.status_dinas === 'disetujui';
            const sudahAbsenMasuk = absensiHariIni && absensiHariIni.jam_masuk;
            const sudahAbsenPulang = absensiHariIni && absensiHariIni.jam_pulang;
            const sedangIzin = absensiHariIni && absensiHariIni.status === 'izin';

            // Tombol Masuk
            if (sudahAbsenMasuk || sedangIzin) {
                btnMasuk.disabled = true;
                btnMasuk.classList.remove('btn-success');
                btnMasuk.classList.add('btn-secondary');
            } else if (sedangDinas) {
                // Jika sedang dinas, tombol masuk tidak aktif karena bisa langsung pulang
                btnMasuk.disabled = true;
                btnMasuk.classList.remove('btn-success');
                btnMasuk.classList.add('btn-secondary');
            }

            // Tombol Pulang - LOGIKA UTAMA PERUBAHAN
            if (sedangDinas && !sudahAbsenPulang) {
                // Jika sedang dinas luar dan belum pulang, tombol pulang aktif
                btnPulang.disabled = false;
                btnPulang.classList.add('btn-warning');
            } else if (!sudahAbsenMasuk || sudahAbsenPulang || sedangIzin) {
                btnPulang.disabled = true;
                if (sudahAbsenPulang) {
                    btnPulang.classList.remove('btn-warning');
                    btnPulang.classList.add('btn-secondary');
                }
            } else if (sudahAbsenMasuk && !sudahAbsenPulang && !sedangIzin) {
                // Cek validasi jam pulang
                const jamValidation = validateJamPulang();
                btnPulang.disabled = !jamValidation.valid || !locationSwitch.checked;
                btnPulang.title = jamValidation.valid ? "" : jamValidation.message;

                if (jamValidation.valid) {
                    btnPulang.classList.add('btn-warning');
                } else {
                    btnPulang.classList.remove('btn-warning');
                    btnPulang.classList.add('btn-secondary');
                }
            }

            // Tombol Izin
            if (absensiHariIni) {
                btnIzin.disabled = true;
                btnIzin.classList.remove('btn-info');
                btnIzin.classList.add('btn-secondary');
            }

            // Tombol Dinas
            if (absensiHariIni) {
                btnDinas.disabled = true;
                btnDinas.classList.remove('btn-primary');
                btnDinas.classList.add('btn-secondary');
            }
        }

        updateButtonStates();
    </script>
@endsection
