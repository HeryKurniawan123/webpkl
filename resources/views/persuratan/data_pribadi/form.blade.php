@extends('layout.main')
@section('content')
    <div class="container-fluid"><br>
        <div class="card shadow mb-4">
            <div class="card-body">

                <h1 class="h3 mb-2 text-gray-800">Data Diri Persuratan  </h1>

                @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif   

                <form action="{{ route('persuratan.data_pribadi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{  old('id', $dataPersuratan->id ?? '') }}">
                   
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', auth()->user()->name ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP / NIK</label>
                        <input type="text"  name="nip" id="nip"  class="form-control"
                            value="{{ old('nip', auth()->user()->nip ?? '') }}" required>
                    </div>
         
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" class="form-control" required>{{ old('alamat', $dataPersuratan->alamat ?? '') }}</textarea>
                    </div>
                    

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No Telpon</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control"
                        value="{{ old('no_hp', $dataPersuratan->no_hp ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                            <label for="jk" class="form-label">Jenis Kelamin</label>
                            <select class="form-control" class="form-select" id="jk" name="jk"
                                required>
                                <option value="Laki-laki"
                                    {{ old('jk', $dataPersuratan->jk ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan"
                                    {{ old('jk', $dataPersuratan->jk ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>

                    <div class="mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <input type="text" name="agama" id="agama" class="form-control"
                        value="{{ old('agama', $dataPersuratan->agama ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                    value="{{ old('tempat_lahir', $dataPersuratan->tempat_lahir ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control"
                    value="{{ old('tgl_lahir', $dataPersuratan->tgl_lahir ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    </div><br>

                    <div class="mb-3">
                        <label class="form-label">Password </label>
                        <input type="password" class="form-control" name="password" placeholder="Password">

                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
