@extends('layout.main')
@section('content')
    <div class="container-fluid"><br>
        <div class="card shadow mb-4">
            <div class="card-body">
                <h1 class="h3 mb-2 text-gray-800">Data Diri Persuratan</h1>
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

                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="">
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control"
                        value="" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIP / NIK</label>
                        <input type="text" name="nip" class="form-control"
                            value="" required>
                    </div>
         
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat_siswa" class="form-control" required>{{ old('alamat_siswa', $dataPribadi->alamat_siswa ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telpon</label>
                        <input type="text" name="no_hp" class="form-control"
                        value="" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-control" name="jk" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki_laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                           
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Agama</label>
                        <input type="text" name="agama" class="form-control"
                        value="" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lhr" class="form-control"
                        value="" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control"
                        value="" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="" required>
                    </div><br>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
