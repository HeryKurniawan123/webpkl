@extends('layout.main')

@section('content')
<div class="container">
    <h4 class="mb-4">Pusat Bantuan - Surat Pengantar</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Input --}}
    <form action="{{ route('surat.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nomor</label>
                <input type="text" name="nomor" value="{{ old('nomor', $data->nomor ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Perihal</label>
                <input type="text" name="perihal" value="{{ old('perihal', $data->perihal ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tempat</label>
                <input type="text" name="tempat" value="{{ old('tempat', $data->tempat ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Buat</label>
                <input type="date" name="tanggalbuat" value="{{ old('tanggalbuat', $data->tanggalbuat ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Awal</label>
                <input type="date" name="tanggal_awal" value="{{ old('tanggal_awal', $data->tanggal_awal ?? '') }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="{{ old('tanggal_akhir', $data->tanggal_akhir ?? '') }}" class="form-control">
            </div>
            <div class="col-md-12 mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $data->deskripsi ?? '') }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama Instansi</label>
                <input type="text" name="nama_instansi" value="{{ old('nama_instansi', $data->nama_instansi ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama Kepala Sekolah</label>
                <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $data->nama_kepsek ?? '') }}" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-success">{{ $data ? 'Update' : 'Simpan' }}</button>
    </form>

</div>
@endsection
