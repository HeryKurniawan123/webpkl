@extends('layout.main')
@section('content')
    <div class="container-fluid"><br>
        <div class="card shadow mb-4">
            <div class="card-body">
                <h1 class="h3 mb-2 text-gray-800">Data Diri Siswa</h1>

                @if (session('success'))
                    <p style="color: green;">{{ session('success') }}</p>
                @endif

                @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('siswa.data_pribadi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ old('id', $dataPribadi->id ?? '') }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control"
                        value="{{ old('name', $siswa->name ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control"
                            value="{{ old('nip', $siswa->nip ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konsentrasi Keahlian</label>
                        <input type="text" name="konsentrasi_keahlian" class="form-control"
                            value="{{ old('konsentrasi_keahlian', $dataPribadi->konsentrasi_keahlian ?? '') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" class="form-control"
                            value="{{ old('kelas', $siswa->kelas ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $siswa->email ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" name="name_ayh" class="form-control"
                            value="{{ old('name_ayh', $dataPribadi->name_ayh ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" name="name_ibu" class="form-control"
                            value="{{ old('name_ibu', $dataPribadi->name_ibu ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control"
                            value="{{ old('nik', $dataPribadi->nik ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" required>{{ old('alamat', $dataPribadi->alamat ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Orang Tua</label>
                        <input type="email" name="email_ortu" class="form-control"
                            value="{{ old('email_ortu', $dataPribadi->email_ortu ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="no_tlp" class="form-control"
                            value="{{ old('no_tlp', $dataPribadi->no_tlp ?? '') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
