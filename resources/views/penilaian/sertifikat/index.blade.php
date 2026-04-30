<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat PKL</title>

<style>
    @page {
        margin: 0cm;
    }
    
    body {
        margin: 0;
        padding: 0;
        font-family: 'Times New Roman', Times, serif;
    }

    /* ===== BACKGROUND IMAGE ===== */
    .bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    /* ===== CONTENT ===== */
    .content {
        position: relative;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    /* ===== TEXT POSITIONS ===== */
    .logo-container {
        position: absolute;
        top: 50px;
        width: 100%;
        text-align: center;
    }

    .logo-img {
        max-height: 80px;
        max-width: 150px;
        object-fit: contain;
    }

    .title {
        position: absolute;
        top: 150px;
        width: 100%;
        text-align: center;
        font-family: 'Times New Roman', Times, serif;
        font-size: 48px;
        font-weight: bold;
        letter-spacing: 5px;
        color: #0f766e;
    }

    .subtitle {
        position: absolute;
        top: 215px;
        width: 100%;
        text-align: center;
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        letter-spacing: 3px;
        color: #555;
    }

    /* Container for dynamic height content to prevent overlap */
    .text-container {
        position: absolute;
        top: 250px;
        width: 100%;
        text-align: center;
    }

    @php
        // Ubah backslash menjadi forward slash agar CSS tidak menganggapnya karakter escape (\f, \t, dll) di Windows
        $fontPath = str_replace('\\', '/', public_path('fonts/TAN MERINGUE Regular.otf'));
    @endphp

    @font-face {
        font-family: 'TAN Meringue';
        src: url("{{ $fontPath }}") format('opentype');
    }

    .nama {
        font-family: 'TAN Meringue', 'Brush Script MT', cursive;
        font-size: 70px;
        color: #0f766e;
        line-height: 1.1;
        margin-bottom: 10px;
    }

    .line {
        margin: 0 auto;
        width: 450px;
        height: 2px;
        background: #999;
    }

    .body-text {
        margin: 20px auto 0;
        width: 70%;
        text-align: center;
        font-size: 16px;
        line-height: 1.8;
        color: #444;
    }

    .predikat {
        display: block;
        margin-top: 10px;
        font-size: 18px;
        font-weight: bold;
        color: #0f766e;
    }

    .signature {
        position: absolute;
        bottom: 80px;
        width: 100%;
        text-align: center;
    }

    .ttd-img {
        width: 130px;
    }

    .ttd-line {
        width: 200px;
        height: 1px;
        background: #333;
        margin: 5px auto;
    }

    .kepsek-name {
        font-size: 15px;
        font-weight: bold;
    }
</style>
</head>

<body>

    <!-- BACKGROUND -->
    <img src="{{ public_path('images/templat-sertifikat.png') }}" class="bg">

    <!-- CONTENT -->
    <div class="content">

        <!-- LOGO IDUKA -->
        @if(!empty($foto_iduka))
            <div class="logo-container">
                <img src="{{ asset('storage/' . $foto_iduka) }}" class="logo-img">
            </div>
        @endif

        <div class="title">SERTIFIKAT PENGAKUAN</div>
        <div class="subtitle">DIBERIKAN KEPADA</div>

        <div class="text-container">
            @php
                $namaVal = $nama ?? 'NAMA SISWA';
                $namaWrapped = wordwrap($namaVal, 18, "<br>");
            @endphp
            <div class="nama">{!! $namaWrapped !!}</div>
            <div class="line"></div>

            <div class="body-text">
                Telah melaksanakan Praktik Kerja Lapangan (PKL) untuk Konsentrasi Keahlian
                <b>{{ $konsentrasi ?? 'Konsentrasi' }}</b> selama {{ $lama ?? 'waktu' }} dari tanggal
                <b>{{ $tanggal_mulai ?? 'tanggal mulai' }}</b> sampai dengan <b>{{ $tanggal_selesai ?? 'tanggal selesai' }}</b>
                dengan nilai yang tercantum di Rapor dengan Predikat :
                @if(!empty($predikat))
                    <span class="predikat">{{ $predikat }}</span>
                @endif
            </div>
        </div>

        <div class="signature">
            <div style="height: 100px;"></div> <!-- Area kosong untuk tanda tangan manual -->
            <div class="ttd-line"></div>
            <div class="kepsek-name">{{ $nama_iduka ?? 'NAMA IDUKA' }}</div>
        </div>

    </div>

</body>
</html>