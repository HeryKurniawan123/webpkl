<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Surat Pengajuan PKL</title>
    <style>
        @page {
            size: 210mm 330mm;
            /* Ukuran kertas F4 */
            margin: 40px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h3,
        p {
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h3 {
            margin-bottom: 5px;
        }

        .header p {
            margin-top: 5px;
        }

        table {
            width: 100%;
            border: none;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: none;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        td:first-child {
            width: 200px;
        }

        td:nth-child(2) {
            width: 20px;
        }

        .signature {
            text-align: center;
            margin-top: 50px;
        }

        .space {
            height: 80px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h3>PEMERINTAH DAERAH PROVINSI JAWA BARAT
            <br>DINAS PENDIDIKAN
            <br>CABANG DINAS PENDIDIKAN WILAYAH XIII
            <br>SMK NEGERI 1 KAWALI
        </h3>
        <p>Jalan Talagasari No.35 Tlp. (0265) 791727 E-Mail:
            <br>smkn1kawali@gmail.com<br>
            Kawali – Kabupaten Ciamis 46253
        </p>
        <hr>
    </div>

    <h4 style="font-weight: normal; text-align: center;">SURAT PENGAJUAN MENCARI TEMPAT PKL TP 2025/2026</h4>

    <table style="border: none;">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $dataPribadi->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td>{{ $dataPribadi->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>{{ $dataPribadi->kelas->kelas ?? '-' }}{{ $dataPribadi->kelas->name_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kompetensi Keahlian</td>
            <td>:</td>
            <td>{{ $dataPribadi->konkes->name_konke ?? '-' }}</td>
        </tr>
    </table>

    <p style="text-align: justify;">Mengajukan tempat Praktik Kerja Lapangan (PKL) Tahun pelajaran 2025/2026, di :</p>

    <table style="border: none;">
        <tr>
            <td>Nama Institusi/Perusahaan</td>
            <td>:</td>
            <td>{{ $usulanIduka->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $usulanIduka->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kompetensi Keahlian</td>
            <td>:</td>
            <td>{{ $usulanIduka->bidang_industri ?? '-' }}</td>
        </tr>
    </table>
    <p>Demikian ajuan ini, untuk dipergunakan sebagaimana mestinya.</p>

    <p style="text-align: right">Kawali, .............2025</p>

    <table style="margin-top: 30px; border: none;">
        <tr>
            <td class="signature">Mengetahui,<br>Orang Tua/Wali<br>
                <div class="space"></div>
                {{ $dataPribadi->name_ayh ?? '-' }}
            </td>
            <td class="signature">Yang Mengajukan,<br>Siswa<br>
                <div class="space"></div>
                {{ $dataPribadi->name ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="signature">Disetujui,<br>Kaprog<br>
                <div class="space"></div>
                @if(isset($kaprog))
                <strong>{{ $kaprog->nama }}</strong><br>
                NIP: {{ $kaprog->nip ?? '-' }}
                @else
                (...........................................)<br>
                NIP: .........................................
                @endif
                
            </td>
        </tr>
    </table>
</body>

</html>