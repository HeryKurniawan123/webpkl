@extends('layout.main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Siswa Bimbingan: {{ $guru->nama }}</h2>

    @if($siswas->count())
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>IDUKA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswas as $s)
                        <tr>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->kelas->kelas ?? '-' }}</td>
                            <td>{{ $s->kelas->name_kelas ?? '-' }}</td>
                            <td>{{ $s->idukaDiterima->nama ?? 'Belum Diterima' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted fst-italic">Belum ada siswa yang dibimbing.</p>
    @endif
</div>
@endsection
