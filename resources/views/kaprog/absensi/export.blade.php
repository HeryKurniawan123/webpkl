<table>
    <thead>
        <tr>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensi as $a)
            <tr>
                <td>{{ $a->user->name }}</td>
                <td>{{ $a->user->kelas->kelas ?? '-' }}</td>
                <td>{{ $a->user->kelas->konke->name_konke ?? '-' }}</td>
                <td>{{ ucfirst($a->status) }}</td>
                <td>{{ $tanggal }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
