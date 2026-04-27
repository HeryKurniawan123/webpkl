<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat PKL</title>
    <style>
        @page {
            size: 297mm 210mm landscape;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 0;
            background: #ffffff;
            overflow: hidden;
        }

        .page {
            width: 297mm;
            height: 210mm;
            position: relative;
            background: #ffffff;
            overflow: hidden;
        }

        /* ========== BACKGROUND WATERMARK ========== */
        .bg-image {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            opacity: 0.07;
            z-index: 0;
        }

        /* ========== TOP LEFT — 3 segitiga bertumpuk ========== */
        .corner-tl-navy {
            position: absolute;
            top: 0; left: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 54mm 54mm 0 0;
            border-color: #0d2b5b transparent transparent transparent;
            z-index: 2;
        }
        .corner-tl-yellow {
            position: absolute;
            top: 0; left: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 36mm 36mm 0 0;
            border-color: #f7c32e transparent transparent transparent;
            z-index: 3;
        }
        .corner-tl-red {
            position: absolute;
            top: 0; left: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 19mm 19mm 0 0;
            border-color: #c1272d transparent transparent transparent;
            z-index: 4;
        }

        /* ========== TOP RIGHT — 3 blok persegi bertangga ========== */
        .corner-tr-navy-rect {
            position: absolute;
            top: 0; right: 0;
            width: 37mm; height: 54mm;
            background: #0d2b5b;
            z-index: 2;
        }
        .corner-tr-yellow-rect {
            position: absolute;
            top: 0; right: 37mm;
            width: 19mm; height: 36mm;
            background: #f7c32e;
            z-index: 2;
        }
        .corner-tr-red-rect {
            position: absolute;
            top: 0; right: 56mm;
            width: 13mm; height: 19mm;
            background: #c1272d;
            z-index: 2;
        }

        /* ========== BOTTOM RIGHT — 2 segitiga ========== */
        .corner-br-yellow {
            position: absolute;
            bottom: 0; right: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 0 0 37mm 37mm;
            border-color: transparent transparent #f7c32e transparent;
            z-index: 2;
        }
        .corner-br-navy {
            position: absolute;
            bottom: 0; right: 0;
            width: 0; height: 0;
            border-style: solid;
            border-width: 0 0 23mm 23mm;
            border-color: transparent transparent #0d2b5b transparent;
            z-index: 3;
        }

        /* ========== CONTENT TABLE ========== */
        /* Gunakan <table> HTML asli — paling kompatibel di DomPDF & wkhtmltopdf */
        .content-table {
            position: absolute;
            top: 0; left: 0;
            width: 297mm;
            height: 210mm;
            z-index: 5;
            border-collapse: collapse;
        }

        .content-td {
            width: 297mm;
            height: 210mm;
            vertical-align: middle;
            text-align: center;
            padding-top: 2mm;
            padding-bottom: 8mm;
            padding-left: 25mm;
            padding-right: 72mm;
        }

        /* ========== JUDUL ========== */
        .header-title {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 22pt;
            letter-spacing: 6pt;
            color: #111111;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 3mm;
            line-height: 1.2;
        }

        /* ========== SUBTITLE ========== */
        .subtitle {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 7.5pt;
            letter-spacing: 2pt;
            color: #555555;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 3mm;
        }

        /* ========== NAMA ========== */
        .nama {
            font-family: Georgia, 'Times New Roman', serif;
            font-weight: bold;
            font-size: 30pt;
            color: #7a2020;
            line-height: 1.15;
            text-align: center;
            margin-bottom: 4mm;
            word-wrap: break-word;
        }

        /* ========== BODY TEXT ========== */
        .body-text {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
            color: #333333;
            line-height: 1.8;
            text-align: center;
            margin-bottom: 5mm;
        }

        .predikat {
            display: block;
            font-size: 12pt;
            font-weight: bold;
            color: #7a2020;
            margin-top: 2mm;
        }

        /* ========== TANDA TANGAN ========== */
        .signature-area {
            text-align: center;
        }

        .ttd-img {
            width: 22mm;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .ttd-line {
            width: 50mm;
            border: none;
            border-top: 1px solid #333333;
            margin: 2mm auto 2mm auto;
            display: block;
        }

        .kepsek-name {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
            color: #111111;
        }

        /* ========== LOGO SEKOLAH ========== */
        .logo-sekolah {
            position: absolute;
            bottom: 8mm;
            right: 10mm;
            width: 23mm;
            height: auto;
            z-index: 10;
        }

    </style>
</head>
<body>
<div class="page">

    {{-- Background watermark --}}
    <img src="{{ public_path('images/smk1.JPG') }}" class="bg-image" alt="">

    {{-- TOP LEFT: 3 segitiga --}}
    <div class="corner-tl-navy"></div>
    <div class="corner-tl-yellow"></div>
    <div class="corner-tl-red"></div>

    {{-- TOP RIGHT: 3 blok persegi --}}
    <div class="corner-tr-navy-rect"></div>
    <div class="corner-tr-yellow-rect"></div>
    <div class="corner-tr-red-rect"></div>

    {{-- BOTTOM RIGHT: 2 segitiga --}}
    <div class="corner-br-yellow"></div>
    <div class="corner-br-navy"></div>

    {{--
        CONTENT: Menggunakan HTML <table> native agar vertical-align:middle
        bekerja di SEMUA renderer PDF (DomPDF, wkhtmltopdf, Snappy, dll.)
    --}}
    <table class="content-table">
        <tr>
            <td class="content-td">

                <div class="header-title">Sertifikat Pengakuan</div>

                <div class="subtitle">Diberikan Kepada :</div>

                <div class="nama">{{ $nama }}</div>

                <div class="body-text">
                    Telah melaksanakan Praktik Kerja Lapangan (PKL) untuk Konsentrasi Keahlian
                    <strong>{{ $konsentrasi }}</strong> selama {{ $lama }} dari tanggal
                    <strong>{{ $tanggal_mulai }}</strong> sampai dengan <strong>{{ $tanggal_selesai }}</strong>
                    dengan nilai yang tercantum di Rapor dengan Predikat :
                    @if(!empty($predikat))
                        <span class="predikat">{{ $predikat }}</span>
                    @endif
                </div>

                <div class="signature-area">
                    <img src="{{ public_path('images/ttd-fajriadi.png') }}" class="ttd-img" alt="ttd">
                    <hr class="ttd-line">
                    <div class="kepsek-name">{{ $kepala_sekolah }}</div>
                </div>

            </td>
        </tr>
    </table>

    {{-- LOGO --}}
    <img src="{{ public_path('images/smk.png') }}" class="logo-sekolah" alt="logo">

</div>
</body>
</html>