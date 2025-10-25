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
                                                : 'Belum di tentukan' }}

                                                                            <br>
                                                                            <strong>Jam Pulang:</strong>
                                                                            {{ Auth::user()->idukaDiterima->jam_pulang
                                                ? date('H:i', strtotime(Auth::user()->idukaDiterima->jam_pulang))
                                                : 'Belum Ditentukan' }}

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
                                        @elseif($absensiHariIni && $absensiHariIni->status_dinas === 'disetujui')
                                            <div class="col-12">
                                                <div class="alert alert-primary">
                                                    <i class="bi bi-briefcase me-2"></i>
                                                    <strong>Anda sedang dinas luar hari ini</strong><br>
                                                    Jenis: {{ ucfirst(str_replace('_', ' ', $absensiHariIni->jenis_dinas)) }}<br>
                                                    Alasan: {{ $absensiHariIni->keterangan_dinas }}<br>
                                                    <small class="text-muted">Anda bisa langsung absen pulang tanpa harus
                                                        absen masuk terlebih dahulu. Absen pulang dapat dilakukan dari mana saja
                                                        setelah
                                                        jam 12.00 siang.</small>
                                                </div>
                                            </div>
                                        @else
                                            @if ($absensiHariIni->jam_masuk)
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="flex-shrink-0">
                                                            <i class="bi bi-clock text-success" style="font-size: 24px;"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="mb-1">Absen Masuk</h6>
                                                            <p class="mb-0 text-success">
                                                                {{ $absensiHariIni->jam_masuk->format('H:i') }}
                                                            </p>
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
                                                            <i class="bi bi-clock-history text-warning" style="font-size: 24px;"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="mb-1">Absen Pulang</h6>
                                                            <p class="mb-0 text-warning">
                                                                {{ $absensiHariIni->jam_pulang->format('H:i') }}
                                                            </p>
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
                @elseif ($hasPendingIzin || $hasPendingDinas || $hasPendingMasuk || $hasPendingPulang)
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card border-warning">
                                <div class="card-header bg-light-warning">
                                    <h5 class="card-title text-warning mb-0">
                                        <i class="bi bi-clock-history me-2"></i>Status Menunggu Konfirmasi
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if ($hasPendingMasuk)
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="flex-shrink-0">
                                                        <i class="bi bi-clock text-warning" style="font-size: 24px;"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-1">Absen Masuk</h6>
                                                        <p class="mb-0 text-warning">
                                                            Menunggu Konfirmasi
                                                        </p>
                                                        <small class="text-muted">
                                                            <span class="badge bg-warning">Pending</span>
                                                            <span class="text-muted ms-2">
                                                                Diajukan:
                                                                {{ $absensiPending->where('jenis', 'masuk')->first()->jam->format('H:i') }}
                                                            </span>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($hasPendingPulang)
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="flex-shrink-0">
                                                        <i class="bi bi-clock-history text-warning" style="font-size: 24px;"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-1">Absen Pulang</h6>
                                                        <p class="mb-0 text-warning">
                                                            Menunggu Konfirmasi
                                                        </p>
                                                        <small class="text-muted">
                                                            <span class="badge bg-warning">Pending</span>
                                                            <span class="text-muted ms-2">
                                                                Diajukan:
                                                                {{ $absensiPending->where('jenis', 'pulang')->first()->jam->format('H:i') }}
                                                            </span>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($hasPendingIzin)
                                            <div class="col-12">
                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    <strong>Izin menunggu konfirmasi</strong><br>
                                                    Jenis:
                                                    {{ ucfirst(str_replace('_', ' ', $izinPending->jenis_izin)) }}<br>
                                                    Alasan: {{ $izinPending->keterangan }}<br>
                                                    <small class="text-muted">Diajukan:
                                                        {{ $izinPending->created_at->format('d/m/Y H:i') }}</small>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($hasPendingDinas)
                                            <div class="col-12">
                                                <div class="alert alert-primary">
                                                    <i class="bi bi-briefcase me-2"></i>
                                                    <strong>Dinas luar menunggu konfirmasi</strong><br>
                                                    Jenis:
                                                    {{ ucfirst(str_replace('_', ' ', $dinasPending->jenis_dinas)) }}<br>
                                                    Alasan: {{ $dinasPending->keterangan }}<br>
                                                    <small class="text-muted">Diajukan:
                                                        {{ $dinasPending->created_at->format('d/m/Y H:i') }}</small>
                                                </div>
                                            </div>
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
                                    <input class="form-check-input" type="checkbox" id="locationSwitch" {{ $absensiHariIni && ($absensiHariIni->status === 'izin' || ($absensiHariIni->jam_masuk && $absensiHariIni->jam_pulang)) ? 'disabled' : '' }}>
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
                                {{-- Pemilihan Lokasi --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="lokasiSelect" class="form-label">Pilih Lokasi Absensi:</label>
                                        <select class="form-select" id="lokasiSelect">
                                            <option value="pusat">Lokasi Pusat</option>
                                            @if (Auth::user()->idukaDiterima && Auth::user()->idukaDiterima->is_pusat)
                                                @foreach (Auth::user()->idukaDiterima->cabangs as $cabang)
                                                    <option value="cabang_{{ $cabang->id }}">{{ $cabang->nama }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                {{-- Tombol-tombol Absensi --}}
                                <div class="row g-3">
                                    {{-- Tombol Absen Masuk --}}
                                    <div class="col-md-3 col-6">
                                        <form method="POST" action="{{ route('absensi.masuk') }}" id="formMasuk">
                                            @csrf
                                            <input type="hidden" name="latitude" id="latitudeMasuk">
                                            <input type="hidden" name="longitude" id="longitudeMasuk">
                                            <input type="hidden" name="accuracy" id="accuracyMasuk">
                                            <input type="hidden" name="lokasi_id" id="lokasiIdMasuk" value="pusat">

                                            <button type="submit" class="btn btn-success w-100 btn-absensi" id="btnMasuk" {{ $absensiHariIni && ($absensiHariIni->jam_masuk || $hasApprovedIzin || $hasApprovedDinas) ? 'disabled' : '' }} {{ $hasPendingIzin || $hasPendingDinas || $hasPendingMasuk ? 'disabled' : '' }}>
                                                <div class="btn-content">
                                                    <i class="bi bi-clock"></i>
                                                    <span class="btn-title">Absen Masuk</span>
                                                    <span class="btn-subtitle">
                                                        @if ($absensiHariIni && $absensiHariIni->jam_masuk)
                                                            Sudah absen: {{ $absensiHariIni->jam_masuk->format('H:i') }}
                                                        @elseif ($hasApprovedIzin)
                                                            Sedang izin
                                                        @elseif ($hasApprovedDinas)
                                                            Sedang dinas luar
                                                        @elseif ($hasPendingIzin)
                                                            Izin menunggu konfirmasi
                                                        @elseif ($hasPendingDinas)
                                                            Dinas menunggu konfirmasi
                                                        @elseif ($hasPendingMasuk)
                                                            Absen masuk menunggu konfirmasi
                                                        @else
                                                            Klik untuk absen masuk
                                                        @endif
                                                    </span>
                                                </div>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Tombol Absen Pulang --}}
                                    <div class="col-md-3 col-6">
                                        <form method="POST" action="{{ route('absensi.pulang.siswa') }}" id="formPulang">
                                            @csrf
                                            <input type="hidden" name="latitude" id="latitudePulang" value="0">
                                            <input type="hidden" name="longitude" id="longitudePulang" value="0">
                                            <input type="hidden" name="accuracy" id="accuracyPulang" value="0">
                                            <input type="hidden" name="lokasi_id" id="lokasiIdPulang" value="pusat">

                                            <button type="submit" class="btn btn-warning w-100 btn-absensi" id="btnPulang"
                                                {{ !$absensiHariIni || !$absensiHariIni->jam_masuk || $absensiHariIni->jam_pulang || $hasApprovedIzin ? 'disabled' : '' }} {{ $hasPendingIzin ? 'disabled' : '' }} @if (!$hasApprovedDinas && $hasPendingDinas) disabled @endif>
                                                @if ($hasPendingPulang) disabled @endif
                                                <div class="btn-content">
                                                    <i class="bi bi-clock-history"></i>
                                                    <span class="btn-title">Absen Pulang</span>
                                                    <span class="btn-subtitle">
                                                        @if ($absensiHariIni && $absensiHariIni->jam_pulang)
                                                            Sudah absen: {{ $absensiHariIni->jam_pulang->format('H:i') }}
                                                        @elseif ($hasApprovedIzin)
                                                            Sedang izin
                                                        @elseif ($hasApprovedDinas)
                                                            @if ($absensiHariIni->jam_pulang)
                                                                Sudah absen: {{ $absensiHariIni->jam_pulang->format('H:i') }}
                                                            @else
                                                                Klik untuk absen pulang
                                                            @endif
                                                        @elseif ($hasPendingIzin)
                                                            Izin menunggu konfirmasi
                                                        @elseif ($hasPendingDinas)
                                                            Dinas menunggu konfirmasi
                                                        @elseif ($hasPendingPulang)
                                                            Absen pulang menunggu konfirmasi
                                                        @elseif (!$absensiHariIni || !$absensiHariIni->jam_masuk)
                                                            Anda harus absen masuk terlebih dahulu
                                                        @else
                                                            Klik untuk absen pulang
                                                        @endif
                                                    </span>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                    {{-- Tombol Izin --}}
                                    <div class="col-md-3 col-6">
                                        <button type="button" class="btn btn-info w-100 btn-absensi" id="btnIzin"
                                            data-bs-toggle="modal" data-bs-target="#modalIzin" {{ $absensiHariIni ? 'disabled' : '' }} {{ $hasPendingIzin || $hasApprovedIzin ? 'disabled' : '' }}
                                            {{ $hasPendingDinas || $hasApprovedDinas ? 'disabled' : '' }} {{ $hasPendingMasuk ? 'disabled' : '' }} {{ $hasPendingPulang ? 'disabled' : '' }}>
                                            <div class="btn-content">
                                                <i class="bi bi-file-earmark-text"></i>
                                                <span class="btn-title">Izin</span>
                                                <span class="btn-subtitle">
                                                    @if ($hasApprovedIzin)
                                                        Sudah izin
                                                    @elseif ($hasPendingIzin)
                                                        Izin menunggu konfirmasi
                                                    @elseif ($absensiHariIni)
                                                        Ada absensi
                                                    @elseif ($hasPendingDinas || $hasApprovedDinas)
                                                        Sedang dinas
                                                    @elseif ($hasPendingMasuk)
                                                        Ada absen masuk pending
                                                    @elseif ($hasPendingPulang)
                                                        Ada absen pulang pending
                                                    @else
                                                        Tidak masuk
                                                    @endif
                                                </span>
                                            </div>
                                        </button>
                                    </div>

                                    {{-- Tombol Dinas Luar --}}
                                    <div class="col-md-3 col-6">
                                        <button type="button" class="btn btn-primary w-100 btn-absensi" id="btnDinas"
                                            data-bs-toggle="modal" data-bs-target="#modalDinas" {{ $absensiHariIni ? 'disabled' : '' }} {{ $hasPendingDinas || $hasApprovedDinas ? 'disabled' : '' }}
                                            {{ $hasPendingIzin || $hasApprovedIzin ? 'disabled' : '' }} {{ $hasPendingMasuk ? 'disabled' : '' }} {{ $hasPendingPulang ? 'disabled' : '' }}>
                                            <div class="btn-content">
                                                <i class="bi bi-briefcase"></i>
                                                <span class="btn-title">Dinas Luar</span>
                                                <span class="btn-subtitle">
                                                    @if ($hasApprovedDinas)
                                                        Sedang dinas
                                                    @elseif ($hasPendingDinas)
                                                        Dinas menunggu konfirmasi
                                                    @elseif ($absensiHariIni)
                                                        Ada absensi
                                                    @elseif ($hasPendingIzin || $hasApprovedIzin)
                                                        Sedang izin
                                                    @elseif ($hasPendingMasuk)
                                                        Ada absen masuk pending
                                                    @elseif ($hasPendingPulang)
                                                        Ada absen pulang pending
                                                    @else
                                                        Tugas luar
                                                    @endif
                                                </span>
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
                            melakukan absensi pulang seperti biasa.
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

        /* Perbaikan tampilan tombol */
        .btn-absensi {
            height: 120px !important;
            padding: 12px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .btn-absensi i {
            font-size: 1.8rem;
            margin-bottom: 8px;
            line-height: 1;
        }

        .btn-title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .btn-subtitle {
            font-size: 0.75rem;
            line-height: 1.2;
            max-width: 100%;
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Pastikan semua tombol memiliki tinggi yang sama di mobile */
        @media (max-width: 767.98px) {
            .btn-absensi {
                height: 100px !important;
                padding: 8px;
            }

            .btn-absensi i {
                font-size: 1.5rem;
                margin-bottom: 5px;
            }

            .btn-title {
                font-size: 0.9rem;
                margin-bottom: 2px;
            }

            .btn-subtitle {
                font-size: 0.7rem;
            }
        }

        /* Efek hover untuk tombol */
        .btn-absensi:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Efek untuk tombol disabled */
        .btn-absensi:disabled {
            opacity: 0.7;
            cursor: not-allowed;
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

        // Status pending dan approved dari server
        const hasPendingIzin = @json($hasPendingIzin ?? false);
        const hasPendingDinas = @json($hasPendingDinas ?? false);
        const hasApprovedIzin = @json($hasApprovedIzin ?? false);
        const hasApprovedDinas = @json($hasApprovedDinas ?? false);

        // Status pending absensi
        const hasPendingMasuk = @json($absensiPending && $absensiPending->where('jenis', 'masuk')->count() > 0);
        const hasPendingPulang = @json($absensiPending && $absensiPending->where('jenis', 'pulang')->count() > 0);

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
        const accuracyMasuk = document.getElementById('accuracyMasuk');
        const latitudePulang = document.getElementById('latitudePulang');
        const longitudePulang = document.getElementById('longitudePulang');
        const accuracyPulang = document.getElementById('accuracyPulang');
        const lokasiSelect = document.getElementById('lokasiSelect');
        const lokasiIdMasuk = document.getElementById('lokasiIdMasuk');
        const lokasiIdPulang = document.getElementById('lokasiIdPulang');

        // Koordinat IDUKA dari user yang login
        @auth
                @if (Auth::user()->idukaDiterima && Auth::user()->idukaDiterima->latitude && Auth::user()->idukaDiterima->longitude)
                    const idukaLat = {{ Auth::user()->idukaDiterima->latitude }};
                    const idukaLng = {{ Auth::user()->idukaDiterima->longitude }};
                    const allowedRadius = {{ Auth::user()->idukaDiterima->radius ?? 100 }};
                    const hasValidIduka = true;
                    // Ambil jam operasional dari IDUKA
                    const jamMasukIduka = "{{ Auth::user()->idukaDiterima->jam_masuk ? Auth::user()->idukaDiterima->jam_masuk->format('H:i') : '08:00' }}";
                    const jamPulangIduka = "{{ Auth::user()->idukaDiterima->jam_pulang ? Auth::user()->idukaDiterima->jam_pulang->format('H:i') : '15:00' }}";
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

                                    // Data cabang
                                    const cabangs = @json(Auth::user()->idukaDiterima && Auth::user()->idukaDiterima->is_pusat ? Auth::user()->idukaDiterima->cabangs : []);

        // Event listener untuk perubahan lokasi
        lokasiSelect.addEventListener('change', function () {
            const selectedValue = this.value;
            lokasiIdMasuk.value = selectedValue;
            lokasiIdPulang.value = selectedValue;

            // Update info lokasi yang ditampilkan
            updateLocationInfo(currentPosition);
        });

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

        // PERBAIKAN: Fungsi untuk validasi jam masuk
        function validateJamMasuk() {
            const now = new Date();
            const [jam, menit] = jamMasukIduka.split(':');
            const jamMasukDate = new Date();
            jamMasukDate.setHours(parseInt(jam), parseInt(menit), 0, 0);

            if (now < jamMasukDate) {
                return {
                    valid: false,
                    message: `Absen masuk hanya dapat dilakukan mulai pukul ${jamMasukIduka}.`
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

        function updateLocationInfo(position) {
            if (!position) return;

            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            const accuracy = position.coords.accuracy;

            // Update lokasi user
            userLocation.textContent = userLat.toFixed(6) + ", " + userLng.toFixed(6);
            locationStatus.textContent = "Lokasi terdeteksi dengan akurasi ±" + Math.round(accuracy) + "m";

            // Jika sedang dinas luar, tampilkan pesan khusus dan skip validasi lokasi
            if (sedangDinas) {
                distanceStatus.textContent = "✅ Anda sedang dinas luar, dapat absen pulang dari mana saja setelah jam 12.00";
                distanceStatus.className = "text-success";
                distanceValue.textContent = "Tidak dibatasi lokasi (dinas luar)";

                // Enable tombol pulang jika sudah jam 12.00
                const now = new Date();
                const jam12 = new Date();
                jam12.setHours(12, 0, 0, 0);
                if (now >= jam12) {
                    btnPulang.disabled = false;
                    btnPulang.title = '';
                } else {
                    btnPulang.disabled = true;
                    btnPulang.title = 'Absen pulang untuk dinas luar hanya dapat dilakukan setelah jam 12.00 siang.';
                }
                return; // Skip sisa validasi lokasi
            }

            // Dapatkan lokasi yang dipilih
            const selectedLokasiId = lokasiSelect.value;
            let targetLat, targetLng, targetRadius, lokasiName;

            if (selectedLokasiId === 'pusat') {
                targetLat = idukaLat;
                targetLng = idukaLng;
                targetRadius = allowedRadius;
                lokasiName = "Pusat";
            } else {
                // Cari cabang yang dipilih
                const cabangId = parseInt(selectedLokasiId.replace('cabang_', ''));
                const selectedCabang = cabangs.find(c => c.id === cabangId);

                if (selectedCabang) {
                    targetLat = parseFloat(selectedCabang.latitude);
                    targetLng = parseFloat(selectedCabang.longitude);
                    targetRadius = parseFloat(selectedCabang.radius) || 100;
                    lokasiName = selectedCabang.nama;
                } else {
                    // Jika cabang tidak ditemukan, gunakan pusat
                    targetLat = idukaLat;
                    targetLng = idukaLng;
                    targetRadius = allowedRadius;
                    lokasiName = "Pusat";
                }
            }

            // Cek apakah koordinat valid
            if (!hasValidIduka || targetLat === null || targetLng === null || targetLat === 0 || targetLng === 0) {
                distanceStatus.textContent = `Koordinat ${lokasiName} belum diatur`;
                distanceStatus.className = "text-warning";
                distanceValue.textContent = "Tidak dapat menghitung jarak";

                // Disable tombol jika tidak ada koordinat yang valid
                if (!sudahAbsenMasuk && !sedangIzin) btnMasuk.disabled = true;
                if (!sudahAbsenPulang && !sedangIzin && sudahAbsenMasuk) btnPulang.disabled = true;
                return;
            }

            // Hitung jarak ke lokasi yang dipilih
            const distance = calculateDistance(userLat, userLng, targetLat, targetLng);

            // Update UI
            distanceValue.textContent = Math.round(distance) + " meter dari " + lokasiName + " (akurasi: ±" + Math.round(accuracy) + "m)";

            // PERBAIKAN: Gunakan akurasi GPS sebagai toleransi
            const effectiveRadius = targetRadius + accuracy;
            const isWithinRadius = distance <= effectiveRadius;

            if (isWithinRadius) {
                distanceStatus.textContent = `✅ Anda berada dalam radius yang diizinkan (${lokasiName})`;
                distanceStatus.className = "text-success";

                // PERBAIKAN: Validasi jam masuk
                const jamValidation = validateJamMasuk();

                // Enable tombol sesuai kondisi
                if (!sudahAbsenMasuk && !sedangIzin) {
                    btnMasuk.disabled = !jamValidation.valid;
                    if (!jamValidation.valid) {
                        btnMasuk.title = jamValidation.message;
                    } else {
                        btnMasuk.title = "";
                    }
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
                distanceStatus.textContent = `❌ Anda berada di luar radius yang diizinkan (${lokasiName})`;
                distanceStatus.className = "text-danger";

                // Disable tombol jika di luar radius
                if (!sudahAbsenMasuk && !sedangIzin) btnMasuk.disabled = true;
                if (!sudahAbsenPulang && !sedangIzin) btnPulang.disabled = true;
            }

            // Isi form dengan koordinat dan akurasi
            if (latitudeMasuk) latitudeMasuk.value = userLat;
            if (longitudeMasuk) longitudeMasuk.value = userLng;
            if (accuracyMasuk) accuracyMasuk.value = accuracy;

            if (latitudePulang) latitudePulang.value = userLat;
            if (longitudePulang) longitudePulang.value = userLng;
            if (accuracyPulang) accuracyPulang.value = accuracy;
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

        // Event listener untuk switch lokasi - PERBAIKAN UTAMA
        locationSwitch.addEventListener('change', function () {
            if (this.checked) {
                // Aktifkan lokasi
                getLocation();

                // Update status tombol berdasarkan kondisi saat ini
                updateButtonStates();
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

                // Update status tombol
                updateButtonStates();
            }
        });

        // Validasi form absen masuk
        document.getElementById('formMasuk').addEventListener('submit', function (e) {
            // Cek apakah lokasi diaktifkan
            if (!locationSwitch.checked) {
                e.preventDefault();
                alert('Silakan aktifkan akses lokasi terlebih dahulu.');
                return false;
            }

            // Cek status pending dan approved
            if (hasPendingIzin || hasApprovedIzin) {
                e.preventDefault();
                alert(hasApprovedIzin ? 'Anda sedang izin hari ini.' :
                    'Anda sudah mengajukan izin. Menunggu konfirmasi.');
                return false;
            }

            if (hasPendingDinas || hasApprovedDinas) {
                e.preventDefault();
                alert(hasApprovedDinas ? 'Anda sedang dinas luar hari ini.' :
                    'Anda sudah mengajukan dinas luar. Menunggu konfirmasi.');
                return false;
            }

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

            // PERBAIKAN: Validasi jam masuk
            const jamValidation = validateJamMasuk();
            if (!jamValidation.valid) {
                e.preventDefault();
                alert(jamValidation.message);
                return false;
            }

            // Dapatkan lokasi yang dipilih
            const selectedLokasiId = lokasiSelect.value;
            let targetLat, targetLng, targetRadius, lokasiName;

            if (selectedLokasiId === 'pusat') {
                targetLat = idukaLat;
                targetLng = idukaLng;
                targetRadius = allowedRadius;
                lokasiName = "Pusat";
            } else {
                // Cari cabang yang dipilih
                const cabangId = parseInt(selectedLokasiId.replace('cabang_', ''));
                const selectedCabang = cabangs.find(c => c.id === cabangId);

                if (selectedCabang) {
                    targetLat = parseFloat(selectedCabang.latitude);
                    targetLng = parseFloat(selectedCabang.longitude);
                    targetRadius = parseFloat(selectedCabang.radius) || 100;
                    lokasiName = selectedCabang.nama;
                } else {
                    // Jika cabang tidak ditemukan, gunakan pusat
                    targetLat = idukaLat;
                    targetLng = idukaLng;
                    targetRadius = allowedRadius;
                    lokasiName = "Pusat";
                }
            }

            if (!hasValidIduka || targetLat === null || targetLng === null || targetLat === 0 || targetLng === 0) {
                e.preventDefault();
                alert(`Koordinat ${lokasiName} belum diatur. Silakan hubungi administrator.`);
                return false;
            }

            const userLat = currentPosition.coords.latitude;
            const userLng = currentPosition.coords.longitude;
            const accuracy = currentPosition.coords.accuracy;
            const distance = calculateDistance(userLat, userLng, targetLat, targetLng);

            // PERBAIKAN: Gunakan akurasi GPS sebagai toleransi
            if (distance > (targetRadius + accuracy)) {
                e.preventDefault();
                alert(
                    `Anda berada di luar radius yang diizinkan untuk absensi di ${lokasiName}.\nJarak Anda: ${Math.round(distance)} meter\nRadius maksimal: ${targetRadius} meter\nAkurasi GPS: ±${Math.round(accuracy)}m\nTotal toleransi: ${Math.round(targetRadius + accuracy)}m`
                );
                return false;
            }
        });

        // Validasi form absen pulang
        document.getElementById('formPulang').addEventListener('submit', function (e) {
            // Cek apakah lokasi diaktifkan
            if (!locationSwitch.checked) {
                e.preventDefault();
                alert('Silakan aktifkan akses lokasi terlebih dahulu.');
                return false;
            }

            // Cek status pending dan approved
            if (hasPendingIzin || hasApprovedIzin) {
                e.preventDefault();
                alert(hasApprovedIzin ? 'Anda sedang izin hari ini.' :
                    'Anda sudah mengajukan izin. Menunggu konfirmasi.');
                return false;
            }

            if (hasPendingDinas && !hasApprovedDinas) {
                e.preventDefault();
                alert('Dinas luar Anda masih menunggu konfirmasi.');
                return false;
            }

            // Jika sedang dinas luar, skip pengecekan absen masuk dan lokasi, tapi cek jam 12.00
            if (sedangDinas) {
                // Validasi jam pulang minimal 12.00 untuk dinas luar
                const now = new Date();
                const jam12 = new Date();
                jam12.setHours(12, 0, 0, 0);

                if (now < jam12) {
                    e.preventDefault();
                    alert('Absen pulang untuk dinas luar hanya dapat dilakukan setelah jam 12.00 siang.');
                    return false;
                }

                // Untuk dinas luar, set nilai default untuk koordinat agar tidak error validasi
                if (latitudePulang) latitudePulang.value = "0";
                if (longitudePulang) longitudePulang.value = "0";
                if (accuracyPulang) accuracyPulang.value = "0";
            } else {
                // Normal case: harus sudah masuk dan belum pulang
                if (!sudahAbsenMasuk) {
                    e.preventDefault();
                    alert('Anda belum melakukan absen masuk hari ini.');
                    return false;
                }

                if (sudahAbsenPulang || sedangIzin) {
                    e.preventDefault();
                    alert(sedangIzin ? 'Anda sedang izin hari ini.' :
                        'Anda sudah melakukan absensi pulang hari ini.');
                    return false;
                }

                // Validasi jam pulang untuk normal case (bukan dinas)
                const jamValidation = validateJamPulang();
                if (!jamValidation.valid) {
                    e.preventDefault();
                    alert(jamValidation.message);
                    return false;
                }

                if (!currentPosition) {
                    e.preventDefault();
                    alert('Lokasi tidak terdeteksi. Silakan aktifkan akses lokasi.');
                    return false;
                }

                // Dapatkan lokasi yang dipilih
                const selectedLokasiId = lokasiSelect.value;
                let targetLat, targetLng, targetRadius, lokasiName;

                if (selectedLokasiId === 'pusat') {
                    targetLat = idukaLat;
                    targetLng = idukaLng;
                    targetRadius = allowedRadius;
                    lokasiName = "Pusat";
                } else {
                    // Cari cabang yang dipilih
                    const cabangId = parseInt(selectedLokasiId.replace('cabang_', ''));
                    const selectedCabang = cabangs.find(c => c.id === cabangId);

                    if (selectedCabang) {
                        targetLat = parseFloat(selectedCabang.latitude);
                        targetLng = parseFloat(selectedCabang.longitude);
                        targetRadius = parseFloat(selectedCabang.radius) || 100;
                        lokasiName = selectedCabang.nama;
                    } else {
                        // Jika cabang tidak ditemukan, gunakan pusat
                        targetLat = idukaLat;
                        targetLng = idukaLng;
                        targetRadius = allowedRadius;
                        lokasiName = "Pusat";
                    }
                }

                if (!hasValidIduka || targetLat === null || targetLng === null || targetLat === 0 || targetLng === 0) {
                    e.preventDefault();
                    alert(`Koordinat ${lokasiName} belum diatur. Silakan hubungi administrator.`);
                    return false;
                }

                const userLat = currentPosition.coords.latitude;
                const userLng = currentPosition.coords.longitude;
                const accuracy = currentPosition.coords.accuracy;
                const distance = calculateDistance(userLat, userLng, targetLat, targetLng);

                // PERBAIKAN: Gunakan akurasi GPS sebagai toleransi
                if (distance > (targetRadius + accuracy)) {
                    e.preventDefault();
                    alert(
                        `Anda berada di luar radius yang diizinkan untuk absensi di ${lokasiName}.\nJarak Anda: ${Math.round(distance)} meter\nRadius maksimal: ${targetRadius} meter\nAkurasi GPS: ±${Math.round(accuracy)}m\nTotal toleransi: ${Math.round(targetRadius + accuracy)}m`
                    );
                    return false;
                }
            }
            // Jika dinas luar, kita tidak perlu validasi lokasi, jadi langsung lanjut
        });
        document.addEventListener('DOMContentLoaded', function () {
            const formIzin = document.getElementById('formIzin');
            const formDinas = document.getElementById('formDinas');
            const modalIzin = new bootstrap.Modal(document.getElementById('modalIzin'));
            const modalDinas = new bootstrap.Modal(document.getElementById('modalDinas'));
            let absensiHariIni = false; // Variabel untuk menyimpan status absensi

            // Cek status izin saat modal dibuka
            document.getElementById('modalIzin').addEventListener('show.bs.modal', function () {
                cekStatusIzin();
            });

            // Cek status dinas saat modal dibuka
            document.getElementById('modalDinas').addEventListener('show.bs.modal', function () {
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
                        absensiHariIni = data.has_attendance || data.has_approved_izin || data
                            .has_pending_masuk || data.has_pending_pulang;

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
                        } else if (data.has_pending_masuk) {
                            // Jika ada absensi masuk pending
                            disableIzinForm(
                                'Anda memiliki absensi masuk yang menunggu konfirmasi. Tidak bisa mengajukan izin.'
                            );
                        } else if (data.has_pending_pulang) {
                            // Jika ada absensi pulang pending
                            disableIzinForm(
                                'Anda memiliki absensi pulang yang menunggu konfirmasi. Tidak bisa mengajukan izin.'
                            );
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
                        absensiHariIni = data.has_attendance || data.has_approved_dinas || data
                            .has_pending_masuk || data.has_pending_pulang;

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
                        } else if (data.has_pending_masuk) {
                            // Jika ada absensi masuk pending
                            disableDinasForm(
                                'Anda memiliki absensi masuk yang menunggu konfirmasi. Tidak bisa mengajukan dinas luar.'
                            );
                        } else if (data.has_pending_pulang) {
                            // Jika ada absensi pulang pending
                            disableDinasForm(
                                'Anda memiliki absensi pulang yang menunggu konfirmasi. Tidak bisa mengajukan dinas luar.'
                            );
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
            document.getElementById('formIzin').addEventListener('submit', function (e) {
                // Cek jika sudah ada absensi (dari hasil fetch sebelumnya)
                if (absensiHariIni) {
                    e.preventDefault();
                    alert('Anda sudah memiliki record absensi hari ini. Tidak bisa mengajukan izin.');
                    return false;
                }

                // Cek status pending dan approved
                if (hasPendingDinas || hasApprovedDinas) {
                    e.preventDefault();
                    alert(hasApprovedDinas ? 'Anda sedang dinas luar hari ini.' :
                        'Anda sudah mengajukan dinas luar. Menunggu konfirmasi.');
                    return false;
                }

                // Cek apakah ada absensi masuk pending
                if (hasPendingMasuk) {
                    e.preventDefault();
                    alert(
                        'Anda memiliki absensi masuk yang menunggu konfirmasi. Tidak bisa mengajukan izin.'
                    );
                    return false;
                }

                // Cek apakah ada absensi pulang pending
                if (hasPendingPulang) {
                    e.preventDefault();
                    alert(
                        'Anda memiliki absensi pulang yang menunggu konfirmasi. Tidak bisa mengajukan izin.'
                    );
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
            document.getElementById('formDinas').addEventListener('submit', function (e) {
                // Cek jika sudah ada absensi (dari hasil fetch sebelumnya)
                if (absensiHariIni) {
                    e.preventDefault();
                    alert('Anda sudah memiliki record absensi hari ini. Tidak bisa mengajukan dinas luar.');
                    return false;
                }

                // Cek status pending dan approved
                if (hasPendingIzin || hasApprovedIzin) {
                    e.preventDefault();
                    alert(hasApprovedIzin ? 'Anda sedang izin hari ini.' :
                        'Anda sudah mengajukan izin. Menunggu konfirmasi.');
                    return false;
                }

                // Cek apakah ada absensi masuk pending
                if (hasPendingMasuk) {
                    e.preventDefault();
                    alert(
                        'Anda memiliki absensi masuk yang menunggu konfirmasi. Tidak bisa mengajukan dinas luar.'
                    );
                    return false;
                }

                // Cek apakah ada absensi pulang pending
                if (hasPendingPulang) {
                    e.preventDefault();
                    alert(
                        'Anda memiliki absensi pulang yang menunggu konfirmasi. Tidak bisa mengajukan dinas luar.'
                    );
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
                    'Apakah Anda yakin ingin mengajukan dinas luar? Setelah dinas diajukan dan disetujui, Anda tetap wajib melakukan absensi pulang seperti biasa.'
                )) {
                    e.preventDefault();
                    return false;
                }
            });

            // Fungsi untuk update status tombol berdasarkan waktu
            function updateButtonStatusBasedOnTime() {
                // Update status tombol masuk jika belum absen masuk
                if (!sudahAbsenMasuk && !sedangIzin && !sedangDinas && !hasPendingIzin && !hasPendingDinas && !hasApprovedIzin && !hasApprovedDinas && !hasPendingMasuk) {
                    const jamValidation = validateJamMasuk();
                    if (locationSwitch.checked) {
                        btnMasuk.disabled = !jamValidation.valid;
                        btnMasuk.title = jamValidation.valid ? "" : jamValidation.message;
                    } else {
                        btnMasuk.disabled = true;
                        btnMasuk.title = "Silakan aktifkan akses lokasi";
                    }
                }

                // Update status tombol pulang jika sudah absen masuk
                if (sudahAbsenMasuk && !sudahAbsenPulang && !sedangIzin && !sedangDinas) {
                    const jamValidation = validateJamPulang();
                    btnPulang.disabled = !jamValidation.valid || !locationSwitch.checked;
                    btnPulang.title = jamValidation.valid ? "" : jamValidation.message;

                    // Update teks pada tombol jika perlu
                    const smallText = btnPulang.querySelector('small');
                    if (smallText && !jamValidation.valid) {
                        smallText.textContent = `Belum waktunya (absen pulang dapat dilakukan ${jamPulangIduka})`;
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
        document.addEventListener('DOMContentLoaded', function () {
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

            // Inisialisasi status tombol
            updateButtonStates();
        });


        function updateButtonStates() {
            // Status dari server
            const absensiHariIni = @json($absensiHariIni);
            const sedangDinas = absensiHariIni && absensiHariIni.status_dinas === 'disetujui';
            const sudahAbsenMasuk = absensiHariIni && absensiHariIni.jam_masuk;
            const sudahAbsenPulang = absensiHariIni && absensiHariIni.jam_pulang;
            const sedangIzin = absensiHariIni && absensiHariIni.status === 'izin';

            // Tombol Masuk - Nonaktifkan jika ada izin/dinas (pending/approved) atau sudah absen masuk
            if (sudahAbsenMasuk || sedangIzin || sedangDinas || hasPendingIzin || hasPendingDinas || hasApprovedIzin ||
                hasApprovedDinas || hasPendingMasuk) {
                btnMasuk.disabled = true;
                btnMasuk.classList.remove('btn-success');
                btnMasuk.classList.add('btn-secondary');
            } else if (!locationSwitch.checked) {
                // Nonaktifkan jika lokasi dimatikan
                btnMasuk.disabled = true;
                btnMasuk.classList.remove('btn-success');
                btnMasuk.classList.add('btn-secondary');
            } else {
                // PERBAIKAN: Validasi jam masuk
                const jamValidation = validateJamMasuk();
                if (!jamValidation.valid) {
                    btnMasuk.disabled = true;
                    btnMasuk.title = jamValidation.message;
                } else {
                    // Aktifkan jika semua kondisi terpenuhi
                    btnMasuk.disabled = false;
                    btnMasuk.title = "";
                }
                btnMasuk.classList.add('btn-success');
                btnMasuk.classList.remove('btn-secondary');
            }

            // Tombol Pulang - Logika khusus untuk dinas luar
            if (sedangDinas && !sudahAbsenPulang) {
                // Cek jam sekarang, jika belum 12.00 maka disable
                const now = new Date();
                const jam12 = new Date();
                jam12.setHours(12, 0, 0, 0);

                if (now < jam12) {
                    btnPulang.disabled = true;
                    btnPulang.title = 'Absen pulang untuk dinas luar hanya dapat dilakukan setelah jam 12.00 siang.';
                } else {
                    btnPulang.disabled = !locationSwitch.checked;
                    btnPulang.title = '';
                }

                if (locationSwitch.checked && now >= jam12) {
                    btnPulang.classList.add('btn-warning');
                    btnPulang.classList.remove('btn-secondary');
                } else {
                    btnPulang.classList.remove('btn-warning');
                    btnPulang.classList.add('btn-secondary');
                }

                // Update teks tombol pulang untuk dinas luar
                const btnSubtitle = btnPulang.querySelector('.btn-subtitle');
                if (btnSubtitle) {
                    if (now < jam12) {
                        btnSubtitle.textContent = 'Dinas luar - bisa pulang setelah jam 12.00';
                    } else {
                        btnSubtitle.textContent = 'Klik untuk absen pulang';
                    }
                }
            } else if (!sudahAbsenMasuk || sudahAbsenPulang || sedangIzin || hasPendingIzin || hasApprovedIzin ||
                hasPendingMasuk || hasPendingPulang) {
                // Nonaktifkan jika belum masuk, sudah pulang, sedang izin, atau ada izin
                btnPulang.disabled = true;
                if (sudahAbsenPulang) {
                    btnPulang.classList.remove('btn-warning');
                    btnPulang.classList.add('btn-secondary');
                }
            } else if (hasPendingDinas && !hasApprovedDinas) {
                // Nonaktifkan jika dinas masih pending
                btnPulang.disabled = true;
                btnPulang.classList.remove('btn-warning');
                btnPulang.classList.add('btn-secondary');
            } else if (sudahAbsenMasuk && !sudahAbsenPulang && !sedangIzin) {
                // Normal case: sudah masuk, belum pulang, bukan izin
                const jamValidation = validateJamPulang();
                btnPulang.disabled = !jamValidation.valid || !locationSwitch.checked;
                btnPulang.title = jamValidation.valid ? "" : jamValidation.message;

                if (jamValidation.valid && locationSwitch.checked) {
                    btnPulang.classList.add('btn-warning');
                    btnPulang.classList.remove('btn-secondary');
                } else {
                    btnPulang.classList.remove('btn-warning');
                    btnPulang.classList.add('btn-secondary');
                }
            }

            // Tombol Izin - Nonaktifkan jika ada absensi/izin/dinas (pending/approved) atau ada absensi masuk pending
            if (absensiHariIni || hasPendingIzin || hasApprovedIzin || hasPendingDinas || hasApprovedDinas ||
                hasPendingMasuk || hasPendingPulang) {
                btnIzin.disabled = true;
                btnIzin.classList.remove('btn-info');
                btnIzin.classList.add('btn-secondary');
            } else {
                btnIzin.disabled = false;
                btnIzin.classList.add('btn-info');
                btnIzin.classList.remove('btn-secondary');
            }

            // Tombol Dinas - Nonaktifkan jika ada absensi/dinas/izin (pending/approved) atau ada absensi masuk pending
            if (absensiHariIni || hasPendingDinas || hasApprovedDinas || hasPendingIzin || hasApprovedIzin ||
                hasPendingMasuk || hasPendingPulang) {
                btnDinas.disabled = true;
                btnDinas.classList.remove('btn-primary');
                btnDinas.classList.add('btn-secondary');
            } else {
                btnDinas.disabled = false;
                btnDinas.classList.add('btn-primary');
                btnDinas.classList.remove('btn-secondary');
            }
        }
        // Panggil updateButtonStates saat halaman dimuat
        updateButtonStates();
    </script>
@endsection
