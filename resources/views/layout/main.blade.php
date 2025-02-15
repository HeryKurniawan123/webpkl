<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" target="_blank" href="{{ asset('images/logo.png') }}" type="image/png">
   

    <meta name="description" content="" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/YOUR-FONT-AWESOME-KIT.js" crossorigin="anonymous"></script>

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
                        <span class="app-brand-text demo fw-bolder ms-2">STUDYFY</span>
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
                            <a href="" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                <div data-i18n="Analytics">Dashboard</div>
                            </a>
                        </li>
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">Data</span>
                        </li>

                        <!-- Layouts -->
                        <li
                            class="menu-item {{ Request::routeIs('admin.tkr', 'admin.tkj', 'admin.pemantauan', 'admin.dpib', 'admin.akl', 'admin.mp', 'admin.sk') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Layouts">Siswa</div>
                            </a>

                            <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('data.siswa') ? 'active' : '' }}">
                                    <a href="/data-siswa" class="menu-link">
                                        <div data-i18n="Without menu">TKR (Data Siswa)</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('admin.tkj') ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div data-i18n="Without menu">TKJ</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('admin.pemantauan') ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div data-i18n="Without menu">RPL</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('admin.dpib') ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div data-i18n="Without menu">DPIB</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('admin.akl') ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div data-i18n="Without menu">AKL</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('admin.mp') ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div data-i18n="Without menu">MP</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('admin.sk') ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div data-i18n="Without menu">SK</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="menu-item {{ Request::routeIs('admin.pemantauanGtk', 'admin.gtkKependidikan') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Layouts">GTK</div>
                            </a>

                            <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('admin.pemantauanGtk') ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div data-i18n="Without menu">Guru</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="#" class="menu-link">
                                        <div data-i18n="Without menu">Tenaga Kependidikan</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item {{ Request::routeIs('data.iduka') ? 'active' : '' }}">
                            <a href="/data-iduka" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Data Iduka</div>
                            </a>
                        </li>



                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">Pusat Control</span>
                        </li>
                        <li
                            class="menu-item {{ Request::routeIs('users.siswa.index', 'users.gtk.index') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-layout"></i>
                                <div data-i18n="Layouts">Tambah User</div>
                            </a>

                            <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('users.siswa.index') ? 'active' : '' }}">
                                    <a href="" class="menu-link">
                                        <div data-i18n="Without menu">Siswa</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('users.gtk.index') ? 'active' : '' }}">
                                    <a href=""class="menu-link">
                                        <div data-i18n="Without menu">GTK</div>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Laporan</div>
                            </a>
                        </li> --}}
                        <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                            <a href="" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-collection"></i>
                                <div data-i18n="Basic">Pust Bantuan</div>
                            </a>
                        </li>
                  

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
                                        <img src="{{ asset('images/ft.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ url(auth()->user()->profile->foto ?? 'default.jpg') }}"
                                                            alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-semibold d-block">{{ auth()->user()->profile->nama ?? auth()->user()->name }}</span>
                                                    <small class="text-muted">{{ auth()->user()->role }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/logout">
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
</body>

</html>
