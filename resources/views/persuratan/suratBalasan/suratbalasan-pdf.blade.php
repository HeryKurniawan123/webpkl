<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Balasan PKL</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { width: 100px; height: auto; }
        .content { line-height: 1.6; }
        .footer { margin-top: 50px; text-align: right; }
        .table-data { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table-data th, .table-data td { border: 1px solid #ddd; padding: 8px; }
        .table-data th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SURAT BALASAN PRAKTIK KERJA LAPANGAN</h2>
        <h3>SMK NEGERI 1 CONTOH</h3>
    </div>

    <div class="content">
        <p>Nomor: ............/SMK1/{{ date('Y') }}</p>
        <p>Hal: Balasan Pengajuan Praktik Kerja Lapangan</p>
        <p>Kepada Yth:</p>
        <p>Bapak/Ibu Pimpinan {{ $iduka->nama }}</p>
        <p>di {{ $iduka->alamat }}</p>
        <br>
        <p>Dengan hormat,</p>
        <p>Menindaklanjuti surat pengajuan Praktik Kerja Lapangan dari:</p>

        <table class="table-data">
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
            </tr>
            <tr>
                <td>{{ $siswa->name }}</td>
                <td>{{ $siswa->kelas->kelas ?? '-' }} {{ $siswa->kelas->name_kelas ?? '-' }}</td>
                <td>{{ $pengajuan->tgl_mulai ? date('d-m-Y', strtotime($pengajuan->tgl_mulai)) : '-' }}</td>
                <td>{{ $pengajuan->tgl_selesai ? date('d-m-Y', strtotime($pengajuan->tgl_selesai)) : '-' }}</td>
            </tr>
        </table>

        <p>Dengan ini kami menyampaikan bahwa:</p>
        <p><strong>Pengajuan tersebut telah DITERIMA</strong> oleh {{ $iduka->nama }}.</p>
        <p>Demikian surat balasan ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
    </div>

    <div class="footer">
        <p>Hormat kami,</p>
        <br><br><br>
        <p><strong>{{ $iduka->konke->name_konke ?? 'Pimpinan' }}</strong></p>
        <p>{{ $iduka->nama }}</p>
    </div>
</body>
</html>