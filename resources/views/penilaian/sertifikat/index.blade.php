<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat PKL</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #ffffff;
        }

        .page {
            width: 1122px;
            height: 794px;
            position: relative;
            background: #ffffff;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        /* ===== BACKGROUND WATERMARK ===== */
        .bg-image {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            opacity: 0.07;
            z-index: 0;
        }

        /* ===== CORNER TOP LEFT ===== */
        .corner-tl-navy {
            position: absolute;
            top: 0; left: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 230px 230px 0 0;
            border-color: #0d2b5b transparent transparent transparent;
            z-index: 2;
        }
        .corner-tl-yellow {
            position: absolute;
            top: 0; left: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 155px 155px 0 0;
            border-color: #f7c32e transparent transparent transparent;
            z-index: 2;
        }
        .corner-tl-red {
            position: absolute;
            top: 0; left: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 80px 80px 0 0;
            border-color: #c1272d transparent transparent transparent;
            z-index: 2;
        }

        /* ===== CORNER TOP RIGHT ===== */
        .corner-tr-navy {
            position: absolute;
            top: 0; right: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 0 230px 230px 0;
            border-color: transparent #0d2b5b transparent transparent;
            z-index: 2;
        }
        .corner-tr-yellow {
            position: absolute;
            top: 0; right: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 0 155px 155px 0;
            border-color: transparent #f7c32e transparent transparent;
            z-index: 2;
        }
        .corner-tr-red {
            position: absolute;
            top: 0; right: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 0 80px 80px 0;
            border-color: transparent #c1272d transparent transparent;
            z-index: 2;
        }

        /* ===== CORNER BOTTOM RIGHT ===== */
        .corner-br-yellow {
            position: absolute;
            bottom: 0; right: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 0 0 160px 160px;
            border-color: transparent transparent #f7c32e transparent;
            z-index: 2;
        }
        .corner-br-navy {
            position: absolute;
            bottom: 0; right: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 0 0 100px 100px;
            border-color: transparent transparent #0d2b5b transparent;
            z-index: 2;
        }

        /* ===== CONTENT ===== */
        .content {
            position: absolute;
            z-index: 5;
            width: 100%;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 55px;
        }

        .header-title {
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 46px;
            letter-spacing: 10px;
            color: #111111;
            text-transform: uppercase;
            text-align: center;
        }

        .subtitle {
            margin-top: 18px;
            font-family: Arial, sans-serif;
            font-weight: normal;
            font-size: 13px;
            letter-spacing: 3px;
            color: #555555;
            text-transform: uppercase;
            text-align: center;
        }

        /* Nama pakai font serif bawaan (mirip Garamond) */
        .nama {
            margin-top: 18px;
            font-family: Georgia, 'Times New Roman', serif;
            font-weight: bold;
            font-size: 78px;
            color: #7a2020;
            line-height: 1;
            letter-spacing: 1px;
            text-align: center;
        }

        .body-text {
            margin-top: 16px;
            max-width: 720px;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333333;
            line-height: 1.75;
        }

        .predikat {
            display: block;
            margin-top: 6px;
            font-size: 18px;
            font-weight: bold;
            color: #7a2020;
        }

        /* ===== SIGNATURE ===== */
        .signature-area {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .ttd-img {
            width: 140px;
        }
        .ttd-line {
            width: 220px;
            height: 1.5px;
            background: #333333;
            margin: 4px 0 6px 0;
        }
        .kepsek-name {
            font-family: Arial, sans-serif;
            font-weight: 500;
            font-size: 14px;
            color: #111111;
            letter-spacing: 0.5px;
            text-align: center;
        }

        /* ===== LOGO ===== */
        .logo-sekolah {
            position: absolute;
            bottom: 32px;
            right: 55px;
            width: 110px;
            z-index: 10;
        }
    </style>
</head>
<body>
<div class="page">

    <img src="{{ public_path('images/bg-sekolah.png') }}" class="bg-image" alt="">

    <!-- TOP LEFT -->
    <div class="corner-tl-navy"></div>
    <div class="corner-tl-yellow"></div>
    <div class="corner-tl-red"></div>

    <!-- TOP RIGHT -->
    <div class="corner-tr-navy"></div>
    <div class="corner-tr-yellow"></div>
    <div class="corner-tr-red"></div>

    <!-- BOTTOM RIGHT -->
    <div class="corner-br-yellow"></div>
    <div class="corner-br-navy"></div>

    <!-- MAIN CONTENT -->
    <div class="content">
        <div class="header-title">Sertifikat Pengakuan</div>
        <div class="subtitle">Diberikan Kepada :</div>
        <div class="nama">{{ $nama }}</div>
        <div class="body-text">
            Telah melaksanakan Praktik Kerja Lapangan (PKL) untuk Konsentrasi Keahlian
            <b>{{ $konsentrasi }}</b> selama {{ $lama }} dari tanggal
            <b>{{ $tanggal_mulai }}</b> sampai dengan <b>{{ $tanggal_selesai }}</b>
            dengan nilai yang tercantum di Rapor dengan Predikat :
            @if(!empty($predikat))
                <span class="predikat">{{ $predikat }}</span>
            @endif
        </div>
        <div class="signature-area">
            <img src="{{ public_path('images/ttd-fajriadi.png') }}" class="ttd-img" alt="ttd">
            <div class="ttd-line"></div>
            <div class="kepsek-name">{{ $kepala_sekolah }}</div>
        </div>
    </div>

    <img src="{{ public_path('images/logo-smkn1kawali.png') }}" class="logo-sekolah" alt="logo">

</div>
</body>
</html>