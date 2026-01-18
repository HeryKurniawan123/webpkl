<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>TATA RIKSA K-ONE</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #5969f3;
            --secondary-color: #764ba2;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --text-color: #333;
            --gray-color: #6c757d;
            --success-color: #4bc0a7;
            --danger-color: #ff6b6b;
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            padding: 1rem 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            font-size: 1.5rem;
            color: var(--primary-color);
            font-weight: 700;
        }

        .navmenu ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .navmenu a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .navmenu a:hover,
        .navmenu a.active {
            color: var(--primary-color);
        }

        .navmenu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: var(--transition);
        }

        .navmenu a:hover::after,
        .navmenu a.active::after {
            width: 100%;
        }

        .mobile-nav-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 80px;
            overflow: hidden;
        }

        .hero-waves {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            opacity: 0.5;
        }

        .carousel {
            width: 100%;
            position: relative;
        }

        .carousel-item {
            display: none;
            text-align: center;
            color: white;
            padding: 3rem 1rem;
        }

        .carousel-item.active {
            display: block;
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .carousel-item h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .highlighted-text {
            color: #ffd700;
        }

        .carousel-item p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-get-started {
            display: inline-block;
            padding: 12px 30px;
            background: white;
            color: var(--primary-color);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-get-started:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .installPWA {
            background: var(--primary-color) !important;
            color: white !important;
        }

        .installPWA:hover {
            background: #4343c9 !important;
        }

        .hidden {
            display: none !important;
        }

        .carousel-control-prev,
        .carousel-control-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.3);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            color: white;
            transition: var(--transition);
        }

        .carousel-control-prev {
            left: 20px;
        }

        .carousel-control-next {
            right: 20px;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: rgba(255,255,255,0.5);
        }

        /* Section Common Styles */
        .section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1rem;
        }

        .section-title p {
            font-size: 1.1rem;
            color: var(--gray-color);
        }

        /* About Section */
        .about {
            background: #fff;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .about-img img {
            width: 100%;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .inner-title {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .our-story {
            background: var(--light-color);
            padding: 2rem;
            border-radius: var(--border-radius);
        }

        .our-story h4 {
            color: var(--gray-color);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .our-story h3 {
            font-size: 1.8rem;
            margin: 0.5rem 0 1rem;
            color: var(--dark-color);
        }

        .our-story ul {
            list-style: none;
            margin: 1.5rem 0;
        }

        .our-story ul li {
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .our-story ul li i {
            color: var(--success-color);
            font-size: 1.2rem;
        }

        .watch-video {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .watch-video i {
            font-size: 3rem;
            color: var(--primary-color);
        }

        .watch-video a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .watch-video a:hover {
            color: var(--primary-color);
        }

        .features {
            background: var(--light-color);
        }

        .features-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 3rem;
            align-items: center;
        }

        .features-image img {
            width: 100%;
            border-radius: var(--border-radius);
        }

        .features-item {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .features-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .features-item i {
            font-size: 2.5rem;
            color: var(--primary-color);
            flex-shrink: 0;
        }

        .features-item h4 {
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .features-item p {
            color: var(--gray-color);
            line-height: 1.6;
        }

        /* Clients Slider */
        .clients {
            background: var(--light-color);
            padding: 60px 0;
        }

        .clients-slider {
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .clients-track {
            display: flex;
            width: calc(250px * 26);
            animation: scroll 60s linear infinite;
        }

        .client-logo {
            width: 250px;
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
            filter: grayscale(100%);
            transition: var(--transition);
        }

        .client-logo:hover img {
            filter: grayscale(0%);
        }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Services/Data Section */
        .services {
            background: white;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .service-item {
            background: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: var(--transition);
            text-align: center;
        }

        .service-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .service-item .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            color: white;
            font-size: 2rem;
        }

        .service-item h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .service-item p {
            color: var(--gray-color);
        }

        /* Grafik Section */
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Call to Action */
        .call-to-action {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-align: center;
            padding: 80px 20px;
            position: relative;
        }

        .call-to-action h3 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .call-to-action p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-btn {
            display: inline-block;
            padding: 15px 40px;
            background: white;
            color: var(--primary-color);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius);
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: var(--transition);
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        /* Contact */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 3rem;
        }

        .info-item {
            display: flex;
            gap: 1rem;
            padding: 1.5rem;
            background: var(--light-color);
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
        }

        .info-item i {
            font-size: 2rem;
            color: var(--primary-color);
            flex-shrink: 0;
        }

        .info-item h3 {
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .info-item p,
        .info-item a {
            color: var(--gray-color);
            text-decoration: none;
        }

        .contact-form {
            background: var(--light-color);
            padding: 2rem;
            border-radius: var(--border-radius);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .submit-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            background: var(--light-color);
            padding: 3rem 0 1rem;
            text-align: center;
        }

        .footer h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .footer p {
            color: var(--gray-color);
            margin-bottom: 2rem;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
        }

        .copyright {
            padding: 1rem 0;
            border-top: 1px solid #ddd;
            color: var(--gray-color);
        }

        /* Scroll Top Button */
        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
            z-index: 999;
        }

        .scroll-top:hover {
            background: var(--secondary-color);
            transform: translateY(-5px);
        }

        .scroll-top.active {
            display: flex;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .navmenu ul {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                padding: 1rem;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            }

            .navmenu ul.active {
                display: flex;
            }

            .mobile-nav-toggle {
                display: block;
            }

            .about-content,
            .features-content,
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .carousel-item h2 {
                font-size: 2rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .services-grid {
                grid-template-columns: 1fr;
            }

            .carousel-item h2 {
                font-size: 1.8rem;
            }

            .carousel-item p {
                font-size: 1rem;
            }

            .button-group {
                flex-direction: column;
            }

            .section-title h2 {
                font-size: 2rem;
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

<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="#hero" class="logo">
                    <h1>TATA RIKSA K-ONE</h1>
                </a>
                <nav class="navmenu">
                    <ul id="nav-menu">
                        <li><a href="#hero" class="active">Beranda</a></li>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#keunggulan">Keunggulan</a></li>
                        <li><a href="#data">Data</a></li>
                        <li><a href="#grafik">Grafik</a></li>
                        <li><a href="#contact">Kontak</a></li>
                        <li><a href="https://drive.google.com/drive/folders/1DAPpFI0mBAiZTafR9esk0auuuUySANG3?usp=sharing" target="_blank">Download</a></li>
                        <li><a href="/login">Log In</a></li>
                    </ul>
                    <i class="mobile-nav-toggle bi bi-list" onclick="toggleMenu()"></i>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container carousel" id="hero-carousel">
                <div class="carousel-item active">
                    <h2>Selamat Datang di <span class="highlighted-text">TATA RIKSA K-ONE</span></h2>
                    <p>Platform pendaftaran PKL untuk siswa SMK, lebih mudah, cepat, dan praktis!</p>
                    <div class="button-group">
                        <a href="/login" class="btn-get-started">Log In</a>
                        <a href="#about" class="btn-get-started">Pelajari Lebih Lanjut</a>
                        <a id="install-btn" class="btn-get-started installPWA hidden" href="javascript:void(0)">
                            <i class="bi bi-download"></i> Install Aplikasi
                        </a>
                    </div>
                </div>

                <div class="carousel-item">
                    <h2>Pendaftaran PKL Tanpa Ribet</h2>
                    <p>Daftar ke perusahaan mitra PKL hanya dengan beberapa langkah sederhana, kapan saja dan di mana saja.</p>
                    <div class="button-group">
                        <a href="/login" class="btn-get-started">Log In</a>
                        <a href="#about" class="btn-get-started">Pelajari Lebih Lanjut</a>
                    </div>
                </div>

                <div class="carousel-item">
                    <h2>Pengalaman Langsung di Dunia Industri</h2>
                    <p>Dapatkan pengalaman PKL yang berharga sebagai bekal menghadapi dunia kerja setelah lulus.</p>
                    <div class="button-group">
                        <a href="/login" class="btn-get-started">Log In</a>
                        <a href="#about" class="btn-get-started">Pelajari Lebih Lanjut</a>
                    </div>
                </div>

                <div class="carousel-item">
                    <h2>Siap Memulai PKL?</h2>
                    <p>Dapatkan kesempatan berharga untuk belajar langsung di dunia industri melalui program PKL yang telah disiapkan khusus untuk siswa SMK.</p>
                    <div class="button-group">
                        <a href="/login" class="btn-get-started">Log In</a>
                        <a href="#about" class="btn-get-started">Pelajari Lebih Lanjut</a>
                        <a id="install-btn" class="btn-get-started animate__animated animate__fadeInUp scrollto installPWA hidden 
   bg-[#5656f0] text-white font-medium px-6 py-3 rounded-lg
   transition duration-300 ease-in-out
   hover:bg-[#4343c9] hover:scale-105 hover:shadow-lg" href="javascript:void(0)">
                                <i class="bi bi-download"></i> Install Aplikasi
                            </a>
                    </div>
                </div>

                <button class="carousel-control-prev" onclick="changeSlide(-1)">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="carousel-control-next" onclick="changeSlide(1)">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none">
                <defs>
                    <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
                </defs>
                <g class="wave1"><use xlink:href="#wave-path" x="50" y="3"></use></g>
                <g class="wave2"><use xlink:href="#wave-path" x="50" y="0"></use></g>
                <g class="wave3"><use xlink:href="#wave-path" x="50" y="9"></use></g>
            </svg>
        </section>

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container">
                <div class="about-content">
                    <div class="about-img">
                        <img src="/images/bljrr.png" alt="About">
                    </div>
                    <div>
                        <h2 class="inner-title">Tentang TATA RIKSA K-ONE</h2>
                        <div class="our-story">
                            <h4>Sejak 2025</h4>
                            <h3>Cerita Kita</h3>
                            <p><b>TATA RIKSA K-ONE</b> hadir untuk membantu siswa memulai perjalanan PKL mereka dengan mudah dan lancar. Kami memahami pentingnya pengalaman PKL yang tepat untuk membangun keterampilan dan pengetahuan di dunia profesional.</p>
                            <ul>
                                <li><i class="bi bi-check-circle"></i> <span>Proses pendaftaran yang cepat dan efisien</span></li>
                                <li><i class="bi bi-check-circle"></i> <span>Kerjasama dengan berbagai perusahaan terkemuka</span></li>
                                <li><i class="bi bi-check-circle"></i> <span>Platform yang mudah digunakan untuk semua siswa</span></li>
                            </ul>
                            <p>Dengan <b>TATA RIKSA K-ONE</b>, kamu dapat memilih dan mendaftar ke program PKL yang sesuai dengan minat dan kebutuhanmu.</p>
                            <div class="watch-video">
                                <i class="bi bi-play-circle"></i>
                                <a href="https://youtu.be/p8vnVk7S5lw?si=6dK9x2CTg0uBP7DF" target="_blank">Tonton Video</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="keunggulan" class="features section">
            <div class="container section-title">
                <h2>Keunggulan TATA RIKSA K-ONE</h2>
                <p>Platform PKL yang dirancang untuk mempermudah siswa SMK dalam menemukan kesempatan PKL di berbagai perusahaan terkemuka.</p>
            </div>
            <div class="container">
                <div class="features-content">
                    <div class="features-image">
                        <img src="/tmp_landing/assets/img/features.png" alt="Features">
                    </div>
                    <div>
                        <div class="features-item">
                            <i class="bi bi-person-check"></i>
                            <div>
                                <h4>Mulai PKL Tanpa Ribet</h4>
                                <p>Proses pendaftaran yang sederhana membantumu langsung terjun ke dunia kerja nyata, sesuai dengan jurusan dan keahlianmu.</p>
                            </div>
                        </div>

                        <div class="features-item">
                            <i class="bi bi-building"></i>
                            <div>
                                <h4>Belajar Langsung di Perusahaan Pilihan</h4>
                                <p>Selama PKL, kamu ditempatkan di perusahaan-perusahaan terbaik yang akan mengasah skill-mu di bidang industri yang kamu tekuni.</p>
                            </div>
                        </div>

                        <div class="features-item">
                            <i class="bi bi-clipboard-check"></i>
                            <div>
                                <h4>Progres PKL yang Terpantau Jelas</h4>
                                <p>Dengan sistem monitoring yang transparan, kamu bisa mengikuti perkembangan PKL-mu, mengetahui apa yang sudah dicapai, dan apa yang perlu ditingkatkan.</p>
                            </div>
                        </div>

                        <div class="features-item">
                            <i class="bi bi-person-lines-fill"></i>
                            <div>
                                <h4>Bekal Nyata untuk Dunia Kerja</h4>
                                <p>Pengalaman PKL ini bukan sekadar tugas sekolah tapi juga bekal penting untuk membangun karier masa depanmu di dunia industri.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Clients Section -->
        <section id="clients" class="clients section">
            <div class="container">
                <div class="clients-slider">
                    <div class="clients-track">
                        <div class="client-logo"><img src="/images/daihatsu.jpg" alt=""></div>
                        <div class="client-logo"><img src="/images/inovindo.png" alt=""></div>
                        <div class="client-logo"><img src="/images/oracle.png" alt=""></div>
                        <div class="client-logo"><img src="/images/skyline.png" alt=""></div>
                        <div class="client-logo"><img src="/images/pptik itb.png" alt=""></div>
                        <div class="client-logo"><img src="/images/logopupr.png" alt=""></div>
                        <div class="client-logo"><img src="/images/mikrotikjpeg.jpeg" alt=""></div>
                        <div class="client-logo"><img src="/images/isi.png" alt=""></div>
                        <div class="client-logo"><img src="/images/pixy.png" alt=""></div>
                        <div class="client-logo"><img src="/images/balai budaya.jpeg" alt=""></div>
                        <div class="client-logo"><img src="/images/asn.png" alt=""></div>
                        <div class="client-logo"><img src="/images/UNY.png" alt=""></div>
                        <div class="client-logo"><img src="/images/sanggarseni.jpeg" alt=""></div>
                        
                        <div class="client-logo"><img src="/images/daihatsu.jpg" alt=""></div>
                        <div class="client-logo"><img src="/images/inovindo.png" alt=""></div>
                        <div class="client-logo"><img src="/images/oracle.png" alt=""></div>
                        <div class="client-logo"><img src="/images/skyline.png" alt=""></div>
                        <div class="client-logo"><img src="/images/pptik itb.png" alt=""></div>
                        <div class="client-logo"><img src="/images/logopupr.png" alt=""></div>
                        <div class="client-logo"><img src="/images/mikrotikjpeg.jpeg" alt=""></div>
                        <div class="client-logo"><img src="/images/isi.png" alt=""></div>
                        <div class="client-logo"><img src="/images/pixy.png" alt=""></div>
                        <div class="client-logo"><img src="/images/balai budaya.jpeg" alt=""></div>
                        <div class="client-logo"><img src="/images/asn.png" alt=""></div>
                        <div class="client-logo"><img src="/images/UNY.png" alt=""></div>
                        <div class="client-logo"><img src="/images/sanggarseni.jpeg" alt=""></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services/Data Section -->
        <section id="data" class="services section">
            <div class="container section-title">
                <h2>Data PKL</h2>
                <p>Informasi lengkap mengenai jumlah siswa, perusahaan, dan data terkait kegiatan PKL</p>
            </div>
            <div class="container">
                <div class="services-grid">
                    <div class="service-item">
                        <div class="icon"><i class="bi bi-people"></i></div>
                        <h3>Total Siswa</h3>
                        <p>Jumlah total siswa yang mengikuti program PKL tahun ini.</p>
                    </div>

                    <div class="service-item">
                        <div class="icon"><i class="bi bi-building"></i></div>
                        <h3>Total Perusahaan</h3>
                        <p>Jumlah perusahaan/industri yang menjadi mitra PKL sekolah.</p>
                    </div>

                    <div class="service-item">
                        <div class="icon"><i class="bi bi-clipboard-data"></i></div>
                        <h3>Total Pendaftaran</h3>
                        <p>Jumlah total pendaftaran PKL yang sudah diajukan siswa.</p>
                    </div>

                    <div class="service-item">
                        <div class="icon"><i class="bi bi-check2-square"></i></div>
                        <h3>Pendaftaran Disetujui</h3>
                        <p>Jumlah pendaftaran PKL yang telah disetujui oleh perusahaan.</p>
                    </div>

                    <div class="service-item">
                        <div class="icon"><i class="bi bi-journal-check"></i></div>
                        <h3>PKL Berjalan</h3>
                        <p>Jumlah siswa yang sedang menjalani PKL di tempat mitra saat ini.</p>
                    </div>

                    <div class="service-item">
                        <div class="icon"><i class="bi bi-award"></i></div>
                        <h3>PKL Selesai</h3>
                        <p>Jumlah siswa yang telah menyelesaikan program PKL dengan sukses.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Grafik Section -->
        <section id="grafik" class="services section">
            <div class="container section-title">
                <h2>Grafik Data PKL</h2>
                <p>Visualisasi data siswa yang mendaftar dan status penerimaan PKL</p>
            </div>
            <div class="container">
                <div class="chart-container">
                    <div id="loadingSpinner" class="loading-spinner">
                        <div class="spinner"></div>
                        <span>Memuat data...</span>
                    </div>
                    <canvas id="pklChart" style="display: none;"></canvas>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section id="call-to-action" class="call-to-action section">
            <div class="container">
                <h3>Siap Daftar PKL?</h3>
                <p>Segera cari dan pilih perusahaan impianmu untuk menjalani pengalaman PKL terbaik. Kesempatanmu untuk belajar langsung di dunia industri dimulai dari sini!</p>
                <a class="cta-btn" href="#hero">Daftar Sekarang</a>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="gallery section">
            <div class="container section-title">
                <h2>Gallery</h2>
                <p>Dokumentasi kegiatan siswa selama menjalani program PKL di berbagai perusahaan mitra.</p>
            </div>
            <div class="container">
                <div class="gallery-grid">
                    <div class="gallery-item">
                        <img src="{{ asset('images/pkl1.jpg') }}?v={{ filemtime(public_path('images/pkl1.jpg')) }}" alt="PPLG">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/pkl2.jpg') }}?v={{ filemtime(public_path('images/pkl2.jpg')) }}" alt="SENI KARAWITAN">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/pkl3.jpg') }}?v={{ filemtime(public_path('images/pkl3.jpg')) }}" alt="DPIB"></div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/pkl4.jpg') }}?v={{ filemtime(public_path('images/pkl4.jpg')) }}" alt="MP">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/pkl5.jpg') }}?v={{ filemtime(public_path('images/pkl5.jpg')) }}" alt="TJKT">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/pkl6.jpg') }}?v={{ filemtime(public_path('images/pkl6.jpg')) }}" alt="TKRO">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/pkl8.jpeg') }}?v={{ filemtime(public_path('images/pkl8.jpeg')) }}" alt="Akuntansi">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/pkl7.jpg') }}?v={{ filemtime(public_path('images/pkl7.jpg')) }}" alt="PPLG">
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <div class="container section-title">
                <h2>Kontak Kami</h2>
                <p>Hubungi kami untuk informasi lebih lanjut seputar program PKL dan pendaftaran.</p>
            </div>
            <div class="container">
                <div class="contact-grid">
                    <div>
                        <div class="info-item">
                            <i class="bi bi-geo-alt"></i>
                            <div>
                                <h3>Alamat</h3>
                                <p>JL Talagasari, No. 35, Kawalimukti, Kawali, Kawalimukti, Ciamis, Kabupaten Ciamis, Jawa Barat 46253</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-telephone"></i>
                            <div>
                                <h3>Telepon</h3>
                                <a href="tel:0265791727">(0265) 791727</a>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-envelope"></i>
                            <div>
                                <h3>Email</h3>
                                <p>smkn1kawali@gmail.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-form">
                        <form>
                            <div class="form-row">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Nama Anda" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email Anda" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Subjek" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Pesan Anda" required></textarea>
                            </div>
                            <button type="submit" class="submit-btn">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <h3>TATA RIKSA K-ONE</h3>
            <p>Platform untuk memudahkan siswa SMK dalam mencari, mendaftar, dan menjalani Praktik Kerja Lapangan (PKL) di dunia industri.</p>
            
            <div class="social-links">
                <a href="https://twitter.com/smkn1kawali" target="_blank"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.facebook.com/SMK-Negeri-1-Kawali-1081500078563328/" target="_blank"><i class="bi bi-facebook"></i></a>
                <a href="https://www.instagram.com/smkn1kawali" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-skype"></i></a>
                <a href="https://twitter.com/smkn1kawali" target="_blank"><i class="bi bi-linkedin"></i></a>
            </div>

            <div class="copyright">
                &copy; <strong>TATA RIKSA K-ONE</strong> | All Rights Reserved<br>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" class="scroll-top" id="scroll-top">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Carousel functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-item');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            slides[index].classList.add('active');
        }

        function changeSlide(direction) {
            currentSlide += direction;
            if (currentSlide >= totalSlides) currentSlide = 0;
            if (currentSlide < 0) currentSlide = totalSlides - 1;
            showSlide(currentSlide);
        }

        // Auto slide
        setInterval(() => {
            changeSlide(1);
        }, 5000);

        // Mobile menu toggle
        function toggleMenu() {
            const menu = document.getElementById('nav-menu');
            menu.classList.toggle('active');
        }

        // Scroll top button
        const scrollTop = document.getElementById('scroll-top');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 100) {
                scrollTop.classList.add('active');
            } else {
                scrollTop.classList.remove('active');
            }
        });

        scrollTop.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== 'javascript:void(0)') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });

        // Active menu on scroll
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.navmenu a[href^="#"]');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 100) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });

        // Chart functionality
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('pklChart').getContext('2d');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const chartCanvas = document.getElementById('pklChart');

            setTimeout(() => {
                const data = {
                    total: 150,
                    diterima: 120,
                    ditolak: 30
                };

                loadingSpinner.style.display = 'none';
                chartCanvas.style.display = 'block';

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
                            legend: { display: false },
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
                                    font: { size: 12, weight: '500' },
                                    callback: function (value) {
                                        return value + ' siswa';
                                    }
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    color: '#495057',
                                    font: { size: 13, weight: '600' }
                                }
                            }
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeOutBounce'
                        }
                    }
                });
            }, 1500);
        });

        // PWA Install
        let deferredPrompt;
        const installBtn = document.getElementById('install-btn');

        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
            installBtn.classList.add('hidden');
        }

        window.addEventListener('beforeinstallprompt', (event) => {
            event.preventDefault();
            deferredPrompt = event;
            if (!(window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true)) {
                installBtn.classList.remove('hidden');
            }
        });

        installBtn.addEventListener('click', () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    deferredPrompt = null;
                    installBtn.classList.add('hidden');
                });
            }
        });

        window.addEventListener('appinstalled', () => {
            installBtn.classList.add('hidden');
        });

        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("/serviceworker.js")
                    .then(reg => console.log("Service Worker registered:", reg))
                    .catch(err => console.log("SW registration failed:", err));
            });
        }
    </script>
</body>
</html>
