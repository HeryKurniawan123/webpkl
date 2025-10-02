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
                                                    {{ Auth::user()->idukaDiterima->radius ?? 'Belum diatur' }} meter
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
                                                            <small class="text-muted">Absensi hari ini sudah lengkap</small>
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

                {{-- Tombol Absensi dan Izin --}}
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
                                    @elseif($absensiHariIni && $absensiHariIni->jam_masuk && $absensiHariIni->jam_pulang)
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
                                        </div>
                                    @endif
                                @endauth

                                <div class="row g-3">
                                    {{-- Tombol Absen Masuk --}}
                                    <div class="col-md-4">
                                        <form method="POST" action="{{ route('absensi.masuk') }}" id="formMasuk">
                                            @csrf
                                            <input type="hidden" name="latitude" id="latitudeMasuk">
                                            <input type="hidden" name="longitude" id="longitudeMasuk">
                                            <button type="submit" class="btn btn-success w-100 btn-lg" id="btnMasuk"
                                                {{ $absensiHariIni && ($absensiHariIni->jam_masuk || $absensiHariIni->status === 'izin') ? 'disabled' : '' }}>
                                                <i class="bi bi-clock me-2"></i>
                                                <div>
                                                    <strong>Absen Masuk</strong>
                                                    <br><small>
                                                        @if ($absensiHariIni && $absensiHariIni->jam_masuk)
                                                            Sudah absen: {{ $absensiHariIni->jam_masuk->format('H:i') }}
                                                        @elseif($absensiHariIni && $absensiHariIni->status === 'izin')
                                                            Sedang izin
                                                        @else
                                                            Klik untuk absen masuk
                                                        @endif
                                                    </small>
                                                </div>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Tombol Absen Pulang --}}
                                    <div class="col-md-4">
                                        <form method="POST" action="{{ route('absensi.pulang.siswa') }}" id="formPulang">
                                            @csrf
                                            <input type="hidden" name="latitude" id="latitudePulang">
                                            <input type="hidden" name="longitude" id="longitudePulang">
                                            <button type="submit" class="btn btn-warning w-100 btn-lg" id="btnPulang"
                                                {{ !$absensiHariIni || !$absensiHariIni->jam_masuk || $absensiHariIni->jam_pulang || $absensiHariIni->status === 'izin' ? 'disabled' : '' }}>
                                                <i class="bi bi-clock-history me-2"></i>
                                                <div>
                                                    <strong>Absen Pulang</strong>
                                                    <br><small>
                                                        @if ($absensiHariIni && $absensiHariIni->jam_pulang)
                                                            Sudah absen: {{ $absensiHariIni->jam_pulang->format('H:i') }}
                                                        @elseif($absensiHariIni && $absensiHariIni->status === 'izin')
                                                            Sedang izin
                                                        @elseif(!$absensiHariIni || !$absensiHariIni->jam_masuk)
                                                            Absen masuk dulu
                                                        @else
                                                            Klik untuk absen pulang
                                                        @endif
                                                    </small>
                                                </div>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Tombol Izin --}}
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-info w-100 btn-lg" id="btnIzin"
                                            data-bs-toggle="modal" data-bs-target="#modalIzin"
                                            {{ $absensiHariIni ? 'disabled' : '' }}>
                                            <i class="bi bi-file-earmark-text me-2"></i>
                                            <div>
                                                <strong>Ajukan Izin</strong>
                                                <br><small>
                                                    @if ($absensiHariIni && $absensiHariIni->status === 'izin')
                                                        Sudah mengajukan izin
                                                    @elseif($absensiHariIni)
                                                        Sudah absen hari ini
                                                    @else
                                                        Klik untuk izin tidak masuk
                                                    @endif
                                                </small>
                                            </div>
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
                        <!-- Tempat untuk alert status izin akan ditambahkan di sini oleh JavaScript -->
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

    <style>
        .izin-status-alert {
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

        // Elemen UI
        const locationSwitch = document.getElementById('locationSwitch');
        const locationStatus = document.getElementById('locationStatus');
        const distanceStatus = document.getElementById('distanceStatus');
        const distanceValue = document.getElementById('distanceValue');
        const userLocation = document.getElementById('userLocation');
        const btnMasuk = document.getElementById('btnMasuk');
        const btnPulang = document.getElementById('btnPulang');
        const btnIzin = document.getElementById('btnIzin');
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
        @else
            const idukaLat = null;
            const idukaLng = null;
            const allowedRadius = 100;
            const hasValidIduka = false;
        @endif
        @else
            const idukaLat = null;
            const idukaLng = null;
            const allowedRadius = 100;
            const hasValidIduka = false;
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

        // Fungsi untuk mendapatkan lokasi
        function getLocation() {
            // Jika sudah lengkap absensi atau sedang izin, jangan ambil lokasi
            if ((sudahAbsenMasuk && sudahAbsenPulang) || sedangIzin) {
                locationStatus.textContent = sedangIzin ? "Sedang izin hari ini" : "Absensi hari ini sudah lengkap";
                return;
            }

            if (navigator.geolocation) {
                locationStatus.textContent = "Mengambil lokasi...";

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
                    btnPulang.disabled = false;
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
            if (!sudahAbsenMasuk) {
                e.preventDefault();
                alert('Anda belum melakukan absen masuk hari ini.');
                return false;
            }

            if (sudahAbsenPulang || sedangIzin) {
                e.preventDefault();
                alert(sedangIzin ? 'Anda sedang izin hari ini.' : 'Anda sudah melakukan absen pulang hari ini.');
                return false;
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
            const modalIzin = new bootstrap.Modal(document.getElementById('modalIzin'));
            let absensiHariIni = false; // Variabel untuk menyimpan status absensi

            // Cek status izin saat modal dibuka
            document.getElementById('modalIzin').addEventListener('show.bs.modal', function() {
                cekStatusIzin();
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

            function showAlert(type, message) {
                // Hapus alert sebelumnya
                const existingAlert = document.querySelector('.alert-dismissible');
                if (existingAlert) {
                    existingAlert.remove();
                }

                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert ${alertClass} alert-dismissible fade show`;
                alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

                // Tempatkan alert di bagian atas halaman
                const container = document.querySelector('.container-fluid');
                container.insertBefore(alertDiv, container.firstChild);

                // Auto hide setelah 5 detik
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
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

        // Update status tombol berdasarkan kondisi
        function updateButtonStates() {
            // Tombol Masuk
            if (sudahAbsenMasuk || sedangIzin) {
                btnMasuk.disabled = true;
                btnMasuk.classList.remove('btn-success');
                btnMasuk.classList.add('btn-secondary');
            }

            // Tombol Pulang
            if (!sudahAbsenMasuk || sudahAbsenPulang || sedangIzin) {
                btnPulang.disabled = true;
                if (sudahAbsenPulang) {
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
        }

        updateButtonStates();
    </script>
@endsection
