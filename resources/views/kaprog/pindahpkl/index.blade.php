@extends('layout.main')

@section('content')
<div class="container" style="padding: 20px;">
    <h1 style="margin-bottom: 20px;">Verifikasi Pengajuan Pindah PKL</h1>

    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
    @endif

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #ddd; padding: 8px;">No</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Nama Siswa</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Kelas</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Tempat PKL</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Status</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pindah as $item)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->nama_siswa }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->kelas_id }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->nama_iduka }}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-transform: capitalize;">{{ $item->status }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">
                    <form action="/kaprog/pindah-pkl/{{ $item->id }}/verifikasi" method="POST" style="display: flex; gap: 5px;">
                        @csrf
                        <button type="submit" name="status" value="diterima" style="background-color: #4CAF50; color: white; border: none; padding: 5px 10px; cursor: pointer;">Diterima</button>
                        <button type="submit" name="status" value="ditolak" style="background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer;">Ditolak</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
