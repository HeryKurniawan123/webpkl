<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>PKL SMKN 1 Kawali</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('tmp_landing/assets/img/favicon.png')}}" rel="icon">
    <link href="{{ asset('tmp_landing/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('tmp_landing/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('tmp_landing/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('tmp_landing/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{ asset('tmp_landing/assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
    <link href="{{ asset('tmp_landing/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{ asset('tmp_landing/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet')}}">

    <!-- Main CSS File -->
    <link href="{{ asset('tmp_landing/assets/css/main.css')}}" rel="stylesheet">

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">

    <!-- =======================================================
  * Template Name: Avilon
  * Template URL: https://bootstrapmade.com/avilon-bootstrap-landing-page-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    <style>
        .clients-slider {
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .clients-track {
            display: flex;
            width: calc(250px * 26);
            /* 250px dikali jumlah logo yang total (13x2 = 26) */
            animation: scroll 60s linear infinite;
        }

        .client-logo {
            width: 250px;
            /* Besar ukuran logo per item */
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .client-logo img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* Hilangkan scrollbar (kalau ada backup browser) */
        .clients-slider::-webkit-scrollbar {
            display: none;
        }

        .clients-slider {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        #grafik {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 40px 0;
            padding: 40px 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        #grafik .section-title h2 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        #grafik .section-title p {
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 400;
            margin-bottom: 30px;
        }

        .chart-container {
            position: relative;
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            border: 1px solid #e9ecef;
            max-width: 800px;
            margin: 0 auto;
        }

        #pklChart {
            max-width: 100% !important;
            height: 400px !important;
        }

        .stats-grid {
            display: none;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            border: 1px solid #e9ecef;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #495057;
        }

        .stat-label {
            color: #6c757d;
            font-weight: 500;
            font-size: 1rem;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
            font-size: 1.2rem;
            color: #6c757d;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 15px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #grafik {
                margin: 20px 0;
                padding: 25px 15px;
            }

            #grafik .section-title h2 {
                font-size: 2rem;
            }

            .chart-container {
                padding: 20px;
                margin: 0 10px;
            }

            #pklChart {
                height: 300px !important;
            }

            .stat-number {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            #grafik .section-title h2 {
                font-size: 1.8rem;
            }

            .chart-container {
                padding: 15px;
            }

            #pklChart {
                height: 250px !important;
            }
        }
    </style>


</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <h1 class="sitename">PKL SMKN 1 Kawali</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Beranda</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#keunggulan">Keunggulan</a></li>
                    <li><a href="#data">Data</a></li>
                    <li><a href="#grafik">Grafik</a></li>
                    {{-- <li class="dropdown"><a href="#"><span>Dropdown</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Dropdown 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                        class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="#">Deep Dropdown 1</a></li>
                                    <li><a href="#">Deep Dropdown 2</a></li>
                                    <li><a href="#">Deep Dropdown 3</a></li>
                                    <li><a href="#">Deep Dropdown 4</a></li>
                                    <li><a href="#">Deep Dropdown 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Dropdown 2</a></li>
                            <li><a href="#">Dropdown 3</a></li>
                            <li><a href="#">Dropdown 4</a></li>
                        </ul>
                    </li> --}}
                    <li><a href="#contact">Kontak</a></li>
                    <li><a href="https://drive.google.com/drive/folders/1DAPpFI0mBAiZTafR9esk0auuuUySANG3?usp=sharing"
                            target="_blank">Download</a></li>
                    <li><a href="{{ route('login')}}">Log In</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <div id="hero-carousel" data-bs-interval="5000" class="container carousel carousel-fade"
                data-bs-ride="carousel">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="carousel-container">
                        <h2 class="animate__animated animate__fadeInDown">Selamat Datang di <span
                                class="highlighted-text">PKL SMKN 1 Kawali</span></h2>
                        <p class="animate__animated animate__fadeInUp">Platform pendaftaran PKL untuk siswa SMK, lebih
                            mudah, cepat, dan praktis!</p>
                        <div class="button-group">
                            <a href="{{ route('login') }}"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">Log In</a>
                            <a href="#about"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">Pelajari Lebih
                                Lanjut</a>
                            <a class="btn-get-started animate__animated animate__fadeInUp scrollto installPWA"
                                href="javascript:void(0)" style="display:none; background:#28a745;">
                                <i class="bi bi-download"></i> Install Aplikasi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="carousel-container">
                        <h2 class="animate__animated animate__fadeInDown">Pendaftaran PKL Tanpa Ribet</h2>
                        <p class="animate__animated animate__fadeInUp">Daftar ke perusahaan mitra PKL hanya dengan
                            beberapa langkah sederhana, kapan saja dan di mana saja.</p>
                        <div class="button-group">
                            <a href="{{ route('login') }}"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">Log In</a>
                            <a href="#about"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">Pelajari Lebih
                                Lanjut</a>
                            <a class="btn-get-started animate__animated animate__fadeInUp scrollto installPWA"
                                href="javascript:void(0)" style="display:none; background:#28a745;">
                                <i class="bi bi-download"></i> Install Aplikasi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <div class="carousel-container">
                        <h2 class="animate__animated animate__fadeInDown">Pengalaman Langsung di Dunia Industri</h2>
                        <p class="animate__animated animate__fadeInUp">Dapatkan pengalaman PKL yang berharga sebagai
                            bekal menghadapi dunia kerja setelah lulus.</p>
                        <div class="button-group">
                            <a href="{{ route('login') }}"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">Log In</a>
                            <a href="#about"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">Pelajari Lebih
                                Lanjut</a>
                            <a class="btn-get-started animate__animated animate__fadeInUp scrollto installPWA"
                                href="javascript:void(0)" style="display:none; background:#28a745;">
                                <i class="bi bi-download"></i> Install Aplikasi
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Slide 4 -->
                <div class="carousel-item">
                    <div class="carousel-container">
                        <h2 class="animate__animated animate__fadeInDown">Siap Memulai PKL?</h2>
                        <p class="animate__animated animate__fadeInUp">Dapatkan kesempatan berharga untuk belajar
                            langsung di dunia industri melalui program PKL yang telah disiapkan khusus untuk siswa SMK.
                        </p>
                        <div class="button-group">
                            <a href="{{ route('login') }}"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">Log In</a>
                            <a href="#about"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">Pelajari Lebih
                                Lanjut</a>
                            <a class="btn-get-started animate__animated animate__fadeInUp scrollto installPWA"
                                href="javascript:void(0)" style="display:none; background:#28a745;">
                                <i class="bi bi-download"></i> Install Aplikasi
                            </a>
                        </div>
                    </div>
                </div>



                <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                </a>

                <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                </a>

            </div>

            <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28 " preserveAspectRatio="none">
                <defs>
                    <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
                    </path>
                </defs>
                <g class="wave1">
                    <use xlink:href="#wave-path" x="50" y="3"></use>
                </g>
                <g class="wave2">
                    <use xlink:href="#wave-path" x="50" y="0"></use>
                </g>
                <g class="wave3">
                    <use xlink:href="#wave-path" x="50" y="9"></use>
                </g>
            </svg>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container">

                <div class="row position-relative">

                    <div class="col-lg-7 about-img" data-aos="zoom-out" data-aos-delay="200"><img
                            src="{{ asset('images/bljrr.png')}}"></div>

                    <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="inner-title">Tentang PKL SMKN 1 Kawali</h2>
                        <div class="our-story rounded-container">
                            <h4>Sejak 2025</h4>
                            <h3>Cerita Kita</h3>
                            <p><b>PKL SMKN 1 Kawali</b> hadir untuk membantu siswa memulai perjalanan PKL mereka dengan
                                mudah dan lancar.Kami memahami pentingnya pengalaman PKL yang tepat untuk membangun
                                keterampilan dan pengetahuan di dunia profesional. Kami bekerja sama dengan berbagai
                                perusahaan terkemuka untuk memberikan kesempatan terbaik bagi setiap siswa.</p>
                            <ul>
                                <li><i class="bi bi-check-circle"></i> <span>Proses pendaftaran yang cepat dan
                                        efisien</span></li>
                                <li><i class="bi bi-check-circle"></i> <span>Kerjasama dengan berbagai perusahaan
                                        terkemuka</span></li>
                                <li><i class="bi bi-check-circle"></i> <span>Platform yang mudah digunakan untuk semua
                                        siswa</span></li>
                            </ul>
                            <p>Dengan <b>PKL SMKN 1 Kawali</b>, kamu dapat memilih dan mendaftar ke program PKL yang
                                sesuai dengan minat dan kebutuhanmu. Kami selalu berusaha memberikan pengalaman terbaik
                                bagi setiap peserta.</p>

                            <div class="watch-video d-flex align-items-center position-relative">
                                <i class="bi bi-play-circle"></i>
                                <a href="https://youtu.be/p8vnVk7S5lw?si=6dK9x2CTg0uBP7DF">Tonton Video</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- /About Section -->



        <section id="keunggulan" class="features section features-2">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Keunggulan PKL SMKN 1 Kawali</h2>
                <p>Platform PKL yang dirancang untuk mempermudah siswa SMK dalam menemukan kesempatan PKL di berbagai
                    perusahaan terkemuka.</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4 justify-content-between">
                    <div class="features-image col-lg-4 d-flex align-items-center" data-aos="fade-up">
                        <img src="{{ asset('tmp_landing/assets/img/features.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-7 d-flex flex-column justify-content-center">

                        <div class="features-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-person-check flex-shrink-0"></i>
                            <div>
                                <h4>Mulai PKL Tanpa Ribet</h4>
                                <p>Proses pendaftaran yang sederhana membantumu langsung terjun ke dunia kerja nyata,
                                    sesuai dengan jurusan dan keahlianmu.</p>
                            </div>
                        </div>

                        <div class="features-item d-flex mt-5" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-building flex-shrink-0"></i>
                            <div>
                                <h4>Belajar Langsung di Perusahaan Pilihan</h4>
                                <p>Selama PKL, kamu ditempatkan di perusahaan-perusahaan terbaik yang akan mengasah
                                    skill-mu di bidang industri yang kamu tekuni.</p>
                            </div>
                        </div>

                        <div class="features-item d-flex mt-5" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-clipboard-check flex-shrink-0"></i>
                            <div>
                                <h4>Progres PKL yang Terpantau Jelas</h4>
                                <p>Dengan sistem monitoring yang transparan, kamu bisa mengikuti perkembangan PKL-mu,
                                    mengetahui apa yang sudah dicapai, dan apa yang perlu ditingkatkan.</p>
                            </div>
                        </div>

                        <div class="features-item d-flex mt-5" data-aos="fade-up" data-aos-delay="500">
                            <i class="bi bi-person-lines-fill flex-shrink-0"></i>
                            <div>
                                <h4>Bekal Nyata untuk Dunia Kerja</h4>
                                <p>Pengalaman PKL ini bukan sekadar tugas sekolah tapi juga bekal penting untuk
                                    membangun karier masa depanmu di dunia industri.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </section><!-- /Features 2 Section -->

        <!-- Clients Section -->
        <section id="clients" class="clients section light-background">
            <div class="container" data-aos="fade-up">
                <div class="clients-slider">
                    <div class="clients-track">
                        <!-- LOGO LOGO -->
                        <div class="client-logo"><img src="{{ asset('images/daihatsu.jpg')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/inovindo.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/oracle.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/skyline.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/pptik itb.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/logopupr.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/mikrotikjpeg.jpeg')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/isi.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/pixy.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/balai budaya.jpeg')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/asn.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/UNY.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/sanggarseni.jpeg')}}" alt=""></div>

                        <!-- DUPLIKAT supaya infinite tanpa putus -->
                        <div class="client-logo"><img src="{{ asset('images/daihatsu.jpg')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/inovindo.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/oracle.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/skyline.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/pptik itb.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/logopupr.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/mikrotikjpeg.jpeg')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/isi.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/pixy.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/balai budaya.jpeg')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/asn.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/UNY.png')}}" alt=""></div>
                        <div class="client-logo"><img src="{{ asset('images/sanggarseni.jpeg')}}" alt=""></div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Services Section -->
        <section id="data" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Data PKL</h2>
                <p>Informasi lengkap mengenai jumlah siswa, perusahaan, dan data terkait kegiatan PKL</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative" style="border-radius: 20px">
                            <div class="icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <h3>Total Siswa</h3>
                            <p>Jumlah total siswa yang mengikuti program PKL tahun ini.</p>
                        </div>
                    </div><!-- End Data Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative" style="border-radius: 20px">
                            <div class="icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <h3>Total Perusahaan</h3>
                            <p>Jumlah perusahaan/industri yang menjadi mitra PKL sekolah.</p>
                        </div>
                    </div><!-- End Data Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative" style="border-radius: 20px">
                            <div class="icon">
                                <i class="bi bi-clipboard-data"></i>
                            </div>
                            <h3>Total Pendaftaran</h3>
                            <p>Jumlah total pendaftaran PKL yang sudah diajukan siswa.</p>
                        </div>
                    </div><!-- End Data Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative" style="border-radius: 20px">
                            <div class="icon">
                                <i class="bi bi-check2-square"></i>
                            </div>
                            <h3>Pendaftaran Disetujui</h3>
                            <p>Jumlah pendaftaran PKL yang telah disetujui oleh perusahaan.</p>
                        </div>
                    </div><!-- End Data Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="service-item position-relative" style="border-radius: 20px">
                            <div class="icon">
                                <i class="bi bi-journal-check"></i>
                            </div>
                            <h3>PKL Berjalan</h3>
                            <p>Jumlah siswa yang sedang menjalani PKL di tempat mitra saat ini.</p>
                        </div>
                    </div><!-- End Data Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-item position-relative" style="border-radius: 20px">
                            <div class="icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <h3>PKL Selesai</h3>
                            <p>Jumlah siswa yang telah menyelesaikan program PKL dengan sukses.</p>
                        </div>
                    </div><!-- End Data Item -->

                </div>

            </div>

        </section><!-- /Data Section -->

        <!-- Section Grafik -->
        <section id="grafik" class="services section mt-5">
            <div class="container section-title" data-aos="fade-up">
                <h2>Grafik Data PKL</h2>
                <p>Visualisasi data siswa yang mendaftar dan status penerimaan PKL</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="200">
                <div class="chart-container">
                    <div id="loadingSpinner" class="loading-spinner">
                        <div class="spinner"></div>
                        <span>Memuat data...</span>
                    </div>
                    <canvas id="pklChart" style="display: none;"></canvas>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number" id="totalSiswa">-</div>
                        <div class="stat-label">Total Siswa</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="siswaDiterima">-</div>
                        <div class="stat-label">Diterima</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="siswaDitolak">-</div>
                        <div class="stat-label">Ditolak</div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Section Grafik -->

        <!-- Call To Action Section -->
        <section id="call-to-action" class="call-to-action section dark-background">

            <img src="assets/img/cta-bg.jpg" alt="">

            <div class="container">
                <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-xl-10">
                        <div class="text-center">
                            <h3>Siap Daftar PKL?</h3>
                            <p>Segera cari dan pilih perusahaan impianmu untuk menjalani pengalaman PKL terbaik.
                                Kesempatanmu untuk belajar langsung di dunia industri dimulai dari sini!</p>
                            <a class="cta-btn" href="#hero">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Call To Action Section -->


        <!-- Faq Section -->
        {{-- <section id="faq" class="faq section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Frequently Asked Questions</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

                        <div class="faq-container">

                            <div class="faq-item faq-active">
                                <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                                <div class="faq-content">
                                    <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus
                                        laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor
                                        rhoncus dolor purus non.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Feugiat scelerisque varius morbi enim nunc faucibus?</h3>
                                <div class="faq-content">
                                    <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                        interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus
                                        scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim.
                                        Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                                <div class="faq-content">
                                    <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci.
                                        Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl
                                        suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis
                                        convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                                <div class="faq-content">
                                    <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                        interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus
                                        scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim.
                                        Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Tempus quam pellentesque nec nam aliquam sem et tortor?</h3>
                                <div class="faq-content">
                                    <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse
                                        in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl
                                        suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Perspiciatis quod quo quos nulla quo illum ullam?</h3>
                                <div class="faq-content">
                                    <p>Enim ea facilis quaerat voluptas quidem et dolorem. Quis et consequatur non sed
                                        in suscipit sequi. Distinctio ipsam dolore et.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>

                    </div><!-- End Faq Column-->

                </div>

            </div>

        </section><!-- /Faq Section --> --}}

        <!-- Team Section -->
        {{-- <section id="team" class="team section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Team</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row">

                    <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="member">
                            <img src="{{ asset('tmp_landing/assets/img/team/team-1.jpg')}}" class="img-fluid" alt="">
                            <div class="member-content">
                                <h4>Walter White</h4>
                                <span>Web Development</span>
                                <p>
                                    Magni qui quod omnis unde et eos fuga et exercitationem. Odio veritatis perspiciatis
                                    quaerat qui aut aut aut
                                </p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                        <div class="member">
                            <img src="{{ asset('tmp_landing/assets/img/team/team-2.jpg')}}" class="img-fluid" alt="">
                            <div class="member-content">
                                <h4>Sarah Jhinson</h4>
                                <span>Marketing</span>
                                <p>
                                    Repellat fugiat adipisci nemo illum nesciunt voluptas repellendus. In architecto
                                    rerum rerum temporibus
                                </p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                        <div class="member">
                            <img src="{{ asset('tmp_landing/assets/img/team/team-3.jpg')}}" class="img-fluid" alt="">
                            <div class="member-content">
                                <h4>William Anderson</h4>
                                <span>Content</span>
                                <p>
                                    Voluptas necessitatibus occaecati quia. Earum totam consequuntur qui porro et
                                    laborum toro des clara
                                </p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                </div>

            </div>

        </section><!-- /Team Section --> --}}

        <!-- Gallery Section -->
        <section id="gallery" class="gallery section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Gallery</h2>
                <p>Dokumentasi kegiatan siswa selama menjalani program PKL di berbagai perusahaan mitra.</p>
            </div>

            <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-0">

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('images/pkl1.jpg')}}" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('images/pkl1.jpg')}}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('images/pkl2.jpg')}}" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('images/pkl2.jpg')}}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('images/pkl8.jpg')}}" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('images/pkl8.jpg')}}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('images/pkl4.jpg')}}" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('images/pkl4.jpg')}}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('images/pkl5.jpg')}}" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('images/pkl5.jpg')}}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('images/pkl6.jpg')}}" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('images/pkl6.jpg')}}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('images/pkl7.jpg')}}" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('images/pkl7.jpg')}}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('images/pkl8.jpg')}}" class="glightbox" data-gallery="images-gallery">
                                <img src="{{ asset('images/pkl8.jpg')}}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Gallery Item -->

                </div>

            </div>

        </section><!-- /Gallery Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak Kami</h2>
                <p>Hubungi kami untuk informasi lebih lanjut seputar program PKL dan pendaftaran.</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-4">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Alamat</h3>
                                <p>JL Talagasari, No. 35, Kawalimukti, Kawali, Kawalimukti, Ciamis, Kabupaten Ciamis,
                                    Jawa Barat 46253</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <a href="tel:0265791727">
                                <i class="bi bi-telephone flex-shrink-0"></i>
                                <div>
                                    <h3>Telepon</h3>
                                    <a href="tel:0265791727" style="text-decoration: none;">(0265) 791727</a>
                                </div>
                            </a>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email</h3>
                                <p>smkn1kawali@gmail.com</p>
                            </div>
                        </div><!-- End Info Item -->

                    </div>

                    <div class="col-lg-8">
                        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Nama Anda"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="Email Anda"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subjek"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Pesan Anda"
                                        required></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">Memuat...</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Pesan Anda telah terkirim. Terima kasih!</div>

                                    <button type="submit">Kirim Pesan</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->


    </main>

    <footer id="footer" class="footer light-background">
        <div class="container">
            <h3 class="sitename">PKL SMKN 1 Kawali</h3>
            <p>Platform untuk memudahkan siswa SMK dalam mencari, mendaftar, dan menjalani Praktik Kerja Lapangan (PKL)
                di dunia industri.</p>

            <div class="social-links d-flex justify-content-center">
                <a href="https://twitter.com/smkn1kawali" target="_blank"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.facebook.com/SMK-Negeri-1-Kawali-1081500078563328/" target="_blank"><i
                        class="bi bi-facebook"></i></a>
                <a href="https://www.instagram.com/smkn1kawali" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-skype"></i></a>
                <a href="https://twitter.com/smkn1kawali" target="_blank"><i class="bi bi-linkedin"></i></a>
            </div>

            <div class="container mt-4">
                <div class="copyright text-center">
                    &copy; <strong class="sitename">PKL SMKN 1 Kawali</strong> | All Rights Reserved
                </div>
                <div class="credits text-center">
                    Designed with ?? for K-One students.
                </div>
            </div>
        </div>
    </footer>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('pklChart').getContext('2d');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const chartCanvas = document.getElementById('pklChart');

            fetch('/api/chart-data')
                .then(response => response.json())
                .then(data => {
                    // Hide loading spinner and show chart
                    loadingSpinner.style.display = 'none';
                    chartCanvas.style.display = 'block';

                    // Update stat cards
                    document.getElementById('totalSiswa').textContent = data.total;
                    document.getElementById('siswaDiterima').textContent = data.diterima;
                    document.getElementById('siswaDitolak').textContent = data.ditolak;

                    // Create modern chart
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Total Siswa', 'Diterima', 'Ditolak'],
                            datasets: [{
                                label: 'Jumlah Siswa',
                                data: [data.total, data.diterima, data.ditolak],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.8)',
                                    'rgba(75, 192, 192, 0.8)',
                                    'rgba(255, 99, 132, 0.8)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 99, 132, 1)'
                                ],
                                borderWidth: 2,
                                borderRadius: 10,
                                borderSkipped: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0,0,0,0.8)',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    cornerRadius: 10,
                                    displayColors: false,
                                    callbacks: {
                                        title: function (context) {
                                            return context[0].label;
                                        },
                                        label: function (context) {
                                            return `${context.parsed.y} siswa`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.1)',
                                        lineWidth: 1
                                    },
                                    ticks: {
                                        color: '#6c757d',
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        },
                                        callback: function (value) {
                                            return value + ' siswa';
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#495057',
                                        font: {
                                            size: 13,
                                            weight: '600'
                                        }
                                    }
                                }
                            },
                            animation: {
                                duration: 2000,
                                easing: 'easeOutBounce'
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    loadingSpinner.innerHTML = '<span style="color: #dc3545;">Gagal memuat data grafik</span>';
                });
        });
    </script>

    <!-- PWA -->
    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("/serviceworker.js")
                    .then(reg => console.log("Service Worker registered:", reg))
                    .catch(err => console.log("SW registration failed:", err));
            });
        }
    </script>

    <!-- Download App -->
    <script>
        let deferredPrompt;
        const installButtons = document.querySelectorAll(".installPWA");

        window.addEventListener("beforeinstallprompt", (e) => {
            e.preventDefault();
            deferredPrompt = e;
            installButtons.forEach(btn => btn.style.display = "inline-block");

            installButtons.forEach((btn) => {
                btn.addEventListener("click", async () => {
                    btn.style.display = "none";
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    console.log(`User response to the install prompt: ${outcome}`);
                    deferredPrompt = null;
                });
            });
        });
    </script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('tmp_landing/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('tmp_landing/assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{ asset('tmp_landing/assets/vendor/aos/aos.js')}}"></script>
    <script src="{{ asset('tmp_landing/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('tmp_landing/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('tmp_landing/assets/js/main.js')}}"></script>

</body>

</html>
