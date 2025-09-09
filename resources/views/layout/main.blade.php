<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" target="_blank" href="{{ asset('images/logo.png') }}" type="image/png">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Favicon -->

    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('snet/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('snet/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('snet/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('snet/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('snet/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('snet/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('snet/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->
    <script src="{{ asset('snet/assets/js/config.js') }}"></script>

    <style>
        .sidebar,
        .navbar {
            background-color: #ffffff !important;
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="#" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('images/logo.png') }}" width="40px" height="40px" alt="">
                        </span>
                        <span class="app-brand-text demo fw-bolder ms-2">SMKN 1 KAWALI</span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->

                    <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                        <a href="@if (auth()->user()->role == 'guru') /dashboard/guru
                                @elseif(auth()->user()->role == 'siswa') /dashboard/siswa
                                @elseif(auth()->user()->role == 'hubin') /dashboard/hubin
                                @elseif(auth()->user()->role == 'kaprog') /dashboard/kaprog
                                @elseif(auth()->user()->role == 'ppkl') /dashboard/ppkl
                                @elseif(auth()->user()->role == 'psekolah') /dashboard/psekolah
                                @elseif(auth()->user()->role == 'iduka') /dashboard/iduka
                                @elseif(auth()->user()->role == 'orangtua') /dashboard/orangtua
                                @elseif(auth()->user()->role == 'persuratan') /dashboard/persuratan
                                @elseif(auth()->user()->role == 'kepsek') /dashboard/kepsek
                                @elseif(auth()->user()->role == 'pendamping') /dashboard/pendamping @endif"
                            class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Data</span>
                    </li>

                    <!-- Layouts -->
                    @if (in_array(auth()->user()->role, ['hubin', 'guru', 'psekolah']))
                        <li class="menu-item {{ Request::routeIs('hubin.iduka.index') ? 'active' : '' }}">
                            <a href="{{ route('hubin.iduka.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Institusi</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('kelas.index') ? 'active' : '' }}">
                            <a href="{{ route('kelas.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Siswa</div>
                            </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('pembimbing.siswa.index') ? 'active' : '' }}">
                            <a href="{{ route('pembimbing.siswa.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Pembimbing</div>
                            </a>
                        </li>

                        <li
                            class="menu-item {{ Request::routeIs('admin.pemantauanGtk', 'admin.gtkKependidikan') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Layouts">GTK</div>
                            </a>

                            <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('guru.index') ? 'active' : '' }}">
                                    <a href="{{ route('guru.index') }}" class="menu-link">
                                        <div data-i18n="Without menu">Guru</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('tk.index') ? 'active' : '' }}">
                                    <a href="{{ route('tk.index') }}" class="menu-link">
                                        <div data-i18n="Without menu">Tenaga Kependidikan</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (auth()->user()->role == 'iduka')
                        <li class="menu-item {{ Request::routeIs('iduka.pribadi') ? 'active' : '' }}">
                            <a href="{{ route('iduka.pribadi') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Pribadi Institusi</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('data.institusi') ? 'active' : '' }}">
                            <a href="{{ route('data.institusi') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Institusi / Perusahaan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('tp.iduka') ? 'active' : '' }}">
                            <a href="{{ route('tp.iduka') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">TP</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('iduka.siswa.diterima') ? 'active' : '' }}">
                            <a href="{{ route('iduka.siswa.diterima') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Daftar Siswa</div>
                            </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('konfir.absen.index') ? 'active' : '' }}">
                            <a href="{{ route('konfir.absen.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Absensi</div>
                            </a>
                        </li>

                        <!-- <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                        <a href="{{ route('iduka.pembimbing.create') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            <div data-i18n="Basic">Pembimbing</div>
                        </a>
                    </li> -->
                    @endif
                    @if (auth()->user()->role == 'siswa')
                        <li class="menu-item {{ Request::routeIs('siswa.data_pribadi.create') ? 'active' : '' }}">
                            <a href="{{ route('siswa.data_pribadi.create') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Pribadi Siswa</div>
                            </a>
                            <a href="{{ route('absensi.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-calendar-check"></i>
                                <div data-i18n="Basic">Absensi</div>
                            </a>
                        </li>
                    @endif
                    @if (in_array(auth()->user()->role, ['hubin', 'guru', 'psekolah']))
                        <li class="menu-item {{ Request::routeIs('data.siswa') ? 'active' : '' }}">
                            <a href="{{ route('data.siswa') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data siswa</div>
                            </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('proker.index') ? 'active' : '' }}">
                            <a href="{{ route('proker.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Program Keahlian</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('konke.index') ? 'active' : '' }}">
                            <a href="{{ route('konke.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Konsentrasi Keahlian</div>
                            </a>
                        </li>
                    @endif
                     @if (in_array(auth()->user()->role, ['hubin']))
                     <li class="menu-item {{ Request::routeIs('data-absen.index') ? 'active' : '' }}">
                            <a href="{{ route('data-absen.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Absensi</div>
                            </a>
                        </li>
                     @endif
                    @if (auth()->user()->role == 'persuratan')
                        <li
                            class="menu-item {{ Request::routeIs('persuratan.data_pribadi.create') ? 'active' : '' }}">
                            <a href="{{ route('persuratan.data_pribadi.create') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Pribadi Persuratan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('pengajuan') ? 'active' : '' }}">
                            <a href="{{ route('persuratan.review') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Review Pengajuan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('cetak.iduka.index') ? 'active' : '' }}">
                            <a href="{{ route('cetak.iduka.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Review Data CP ATP</div>
                            </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('persuratan.suratBalasan') ? 'active' : '' }}">
                            <a href="{{ route('persuratan.suratBalasan') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Review Surat Balasan</div>
                            </a>
                        </li>
                    @endif
                    @if (in_array(auth()->user()->role, ['iduka']))
                        <li class="menu-item {{ Request::routeIs('review.pengajuan') ? 'active' : '' }}">
                            <a href="{{ route('pengajuan.review') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Review Pengajuan</div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->role == 'kaprog')
                        <li class="menu-item {{ Request::routeIs('data.iduka') ? 'active' : '' }}">
                            <a href="/data-iduka" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Institusi</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('cp.index') ? 'active' : '' }}">
                            <a href="{{ route('cp.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Tujuan Pembelajaran</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('review.usulan') ? 'active' : '' }}">
                            <a href="{{ route('review.usulan') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Review Usulan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('kaprog.review.pengajuan') ? 'active' : '' }}">
                            <a href="{{ route('kaprog.review.pengajuan') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Review Pengajuan</div>
                            </a>
                        </li>

                        <li class="menu-item {{ Request::routeIs('absen.siswa.kaprog') ? 'active' : '' }}">
                            <a href="{{ route('absen.siswa.kaprog') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Absensi</div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->role == 'hubin')
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">Pusat Control</span>
                        </li>
                        {{-- <li
                            class="menu-item {{ Request::routeIs('data.siswa', 'users.gtk.index') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-layout"></i>
                                <div data-i18n="Layouts">Tambah User</div>
                            </a>

                            <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('siswa.index') ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div data-i18n="Without menu">Siswa</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('users.gtk.index') ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div data-i18n="Without menu">GTK</div>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}

                        <li class="menu-item {{ Request::routeIs('pusatbantuan.index') ? 'active' : '' }}">
                            <a href="{{ route('pusatbantuan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Pusat Bantuan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('hubin.iduka.daftar') ? 'active' : '' }}">
                            <a href="{{ route('hubin.iduka.daftar') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Daftar Iduka</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('hubin.daftarcetak') ? 'active' : '' }}">
                            <a href="{{ route('hubin.daftarcetak') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Daftar Cetak</div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->role == 'pendamping')
                        <li class="menu-item {{ Request::routeIs('pendamping.iduka.index') ? 'active' : '' }}">
                            <a href="{{ route('pendamping.iduka.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Institusi</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('pendamping.kelas.index') ? 'active' : '' }}">
                            <a href="{{ route('pendamping.kelas.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Siswa</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ Request::routeIs('admin.pemantauanGtk', 'admin.gtkKependidikan') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Layouts">GTK</div>
                            </a>

                            <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('pendamping.guru.index') ? 'active' : '' }}">
                                    <a href="{{ route('pendamping.guru.index') }}" class="menu-link">
                                        <div data-i18n="Without menu">Guru</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('pendamping.tk.index') ? 'active' : '' }}">
                                    <a href="{{ route('pendamping.tk.index') }}" class="menu-link">
                                        <div data-i18n="Without menu">Tenaga Kependidikan</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->role == 'kepsek')
                        <li class="menu-item {{ Request::routeIs('kepsek.reviewPengajuanSiswa') ? 'active' : '' }}">
                            <a href="{{ route('kepsek.reviewPengajuanSiswa') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Pengajuan PKL Siswa</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('kepsek.iduka.index') ? 'active' : '' }}">
                            <a href="{{ route('kepsek.iduka.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Institusi</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('kepsek.kelas.index') ? 'active' : '' }}">
                            <a href="{{ route('kepsek.kelas.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Siswa</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ Request::routeIs('admin.pemantauanGtk', 'admin.gtkKependidikan') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Layouts">GTK</div>
                            </a>

                            <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('kepsek.guru.index') ? 'active' : '' }}">
                                    <a href="{{ route('kepsek.guru.index') }}" class="menu-link">
                                        <div data-i18n="Without menu">Guru</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('kepsek.tk.index') ? 'active' : '' }}">
                                    <a href="{{ route('kepsek.tk.index') }}" class="menu-link">
                                        <div data-i18n="Without menu">Tenaga Kependidikan</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (in_array(auth()->user()->role, ['hubin', 'kaprog', 'kepsek']))
                        <li class="menu-item {{ Request::routeIs('laporan.iduka.index') ? 'active' : '' }}">
                            <a href="{{ route('laporan.iduka.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                                <div data-i18n="Basic">Laporan Iduka</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('progres.siswa.index') ? 'active' : '' }}">
                            <a href="{{ route('progres.siswa.index') }}" class="menu-link">
                                <i class="menu-icon bx bx-line-chart"></i>
                                <div data-i18n="Basic">Progres Siswa</div>
                            </a>
                        </li>
                    @endif


                </ul>
            </aside>
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        {{-- <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none"
                                    placeholder="Search..." aria-label="Search..." />
                            </div>
                        </div> --}}
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User -->
                            <li style="margin-right: 10px">{{ auth()->user()->profile->nama ?? auth()->user()->name }}
                            </li>
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/default.jpg') }}"
                                            alt="Foto Profil" class="rounded-circle" width="50" height="50">


                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/default.jpg') }}"
                                                            alt="Foto Profil" class="rounded-circle" width="50"
                                                            height="50">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block text-truncate"
                                                        style="max-width: 150px;"
                                                        title="{{ auth()->user()->profile->nama ?? auth()->user()->name }}">
                                                        {{ auth()->user()->profile->nama ?? auth()->user()->name }}
                                                    </span>
                                                    <small class="text-muted">{{ auth()->user()->role }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item logout-btn" href="/logout">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>


                @yield('content')

            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->


        <script>
            document.querySelectorAll('.logout-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: "Apakah kamu yakin?",
                        text: "Data ini tidak bisa dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Logout!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = this.href; // Arahkan ke URL logout
                        }
                    });
                });
            });

            // setTimeout(() => {
            //     document.querySelector('.sidebar').style.backgroundColor = '#ffff';
            //     document.querySelector('.navbar').style.backgroundColor = '#ffff';
            // }, 500);
        </script>


        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="{{ asset('snet/assets/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('snet/assets/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('snet/assets/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('snet/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

        <script src="{{ asset('snet/assets/vendor/js/menu.js') }}"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{ asset('snet/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('snet/assets/js/main.js') }}"></script>

        <!-- Page JS -->
        <script src="{{ asset('snet/assets/js/dashboards-analytics.js') }}"></script>

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>

        {{-- sweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        @stack('scripts')

</body>

</html>
