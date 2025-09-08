<h3>Data Absensi Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</h3>

<table>
    <thead>
        <tr>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Status</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataAbsensi as $absen)
            <tr>
                <td>{{ $absen->user->name }}</td>
                <td>{{ $absen->user->kelas->kelas ?? '-' }} {{ $absen->user->kelas->name_kelas ?? '' }}</td>
                <td>{{ ucfirst($absen->status) }}</td>
                <td>{{ $absen->jam_masuk ?? '-' }}</td>
                <td>{{ $absen->jam_pulang ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
