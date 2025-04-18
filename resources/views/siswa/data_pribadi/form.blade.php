@extends('layout.main')
@section('content')
    <div class="container-fluid"><br>
        <div class="card shadow mb-4">
            <div class="card-body">
                <h1 class="h3 mb-2 text-gray-800">Data Diri Siswa</h1>
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

                <form action="{{ route('siswa.data_pribadi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ old('id', $dataPribadi->id ?? '') }}">

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap*</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $siswa->name ?? '') }}" required>
                        <small class="form-text text-muted"><i>Nama lengkap ini akan tercatat di sistem, pastikan sudah benar!</i></small>
                    </div>                    

                    <div class="mb-3">
                        <label class="form-label">NIS*</label>
                        <input type="text" name="nip" class="form-control"
                            value="{{ old('nip', $siswa->nip ?? '') }}" required>
                            <small class="form-text text-muted"><i>Pastikan penulisan NIS sudah sesuai dengan data resmi sekolah!</i></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas*</label>
                        <select class="form-control" name="kelas_id" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $kls)
                                <option value="{{ $kls->id }}" {{ $siswa->kelas_id == $kls->id ? 'selected' : '' }}>
                                    {{ $kls->kelas }} {{ $kls->name_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted"><i>Pastikan penulisan kelas sudah benar sesuai dengan tingkat dan jurusanmu!</i></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Konsentrasi Keahlian*</label>
                        <select class="form-control" name="konke_id" required>
                            <option value="">Pilih Konsentrasi Keahlian</option>
                            @foreach ($konke as $k)
                                <option value="{{ $k->id }}" {{ $siswa->konke_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->name_konke }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted"><i>Pastikan pemilihan Konsentrasi Kelahlian sudah benar sesuai dengan tingkat dan jurusanmu!</i></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat*</label>
                        <textarea name="alamat_siswa" class="form-control" required>{{ old('alamat_siswa', $dataPribadi->alamat_siswa ?? '') }}</textarea>
                        <small class="form-text text-muted"><i>Pastikan alamat ditulis dengan lengkap dan sesuai, agar dapat digunakan dengan tepat jika diperlukan.</i></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telepon Siswa*</label>
                        <input type="text" name="no_hp" class="form-control"
                            value="{{ old('no_hp', $dataPribadi->no_hp ?? '') }}" required>
                            <small class="form-text text-muted"><i>Gunakan nomor yang aktif dan bisa dihubungi.</i></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin*</label>
                        <select class="form-control" name="jk" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki_laki"
                                {{ old('jk', $dataPribadi->jk ?? '') == 'laki_laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan"
                                {{ old('jk', $dataPribadi->jk ?? '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Agama*</label>
                        <input type="text" name="agama" class="form-control"
                            value="{{ old('agama', $dataPribadi->agama ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir*</label>
                        <input type="text" name="tempat_lhr" class="form-control"
                            value="{{ old('tempat_lhr', $dataPribadi->tempat_lhr ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal <Lahir></Lahir></label>
                        <input type="date" name="tgl_lahir" class="form-control"
                            value="{{ old('tgl_lahir', $dataPribadi->tgl_lahir ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email*</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $siswa->email ?? '') }}" required>
                            <small class="form-text text-muted"><i>Masukkan email aktif. Pastikan bisa diakses!</i></small>
                    </div><br>
                    {{-- ayah --}}
                    <h1 class="h3 mb-2 text-gray-800">Data Orang Tua</h1><br>
                    <h3 class="h5 mb-2 text-gray-800 " style="color: #696cff;">Data Ayah</h3>
                    <div class="mb-3">
                        <label class="form-label">Nama Ayah*</label>
                        <input type="text" name="name_ayh" class="form-control"
                            value="{{ old('name_ayh', $dataPribadi->name_ayh ?? '') }}" required>
                            <small class="form-text text-muted"><i>Tuliskan nama lengkap ayah sesuai dengan data kependudukan.</i></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIK Ayah*</label>
                        <input type="text" name="nik_ayh" class="form-control"
                            value="{{ old('nik_ayh', $dataPribadi->nik_ayh ?? '') }}" required>
                            <small class="form-text text-muted"><i>Masukkan NIK dengan benar sesuai data resmi yang berlaku.</i></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir Ayah*</label>
                        <input type="text" name="tempat_lhr_ayh" class="form-control"
                            value="{{ old('tempat_lhr_ayh', $dataPribadi->tempat_lhr_ayh ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir Ayah*</label>
                        <input type="date" name="tgl_lahir_ayh" class="form-control"
                            value="{{ old('tgl_lahir_ayh', $dataPribadi->tgl_lahir_ayh ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pekerjaan Ayah*</label>
                        <input type="text" name="pekerjaan_ayh" class="form-control"
                            value="{{ old('pekerjaan_ayh', $dataPribadi->pekerjaan_ayh ?? '') }}" required>
                    </div><br>
                    {{-- ibu --}}
                    <h3 class="h5 mb-2 text-gray-800 " style="color: #696cff;">Data Ibu</h3>
                    <div class="mb-3">
                        <label class="form-label">Nama Ibu*</label>
                        <input type="text" name="name_ibu" class="form-control"
                            value="{{ old('name_ibu', $dataPribadi->name_ibu ?? '') }}" required>
                            <small class="form-text text-muted"><i>Tuliskan nama lengkap ayah sesuai dengan data kependudukan.</i></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIK Ibu*</label>
                        <input type="text" name="nik_ibu" class="form-control"
                            value="{{ old('nik_ibu', $dataPribadi->nik_ibu ?? '') }}" required>
                            <small class="form-text text-muted"><i>Masukkan NIK dengan benar sesuai data resmi yang berlaku.</i></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir Ibu*</label>
                        <input type="text" name="tempat_lhr_ibu" class="form-control"
                            value="{{ old('tempat_lhr_ibu', $dataPribadi->tempat_lhr_ibu ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir Ibu*</label>
                        <input type="date" name="tgl_lahir_ibu" class="form-control"
                            value="{{ old('tgl_lahir_ibu', $dataPribadi->tgl_lahir_ibu ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pekerjaan Ibu*</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control"
                            value="{{ old('pekerjaan_ibu', $dataPribadi->pekerjaan_ibu ?? '') }}" required>
                    </div>


                    {{-- info ortu --}}
                    <div class="mb-3">
                        <label class="form-label">Email Orang Tua*</label>
                        <input type="email" name="email_ortu" class="form-control"
                            value="{{ old('email_ortu', $dataPribadi->email_ortu ?? '') }}" required>
                            <small class="form-text text-muted"><i>Pastikan alamat email yang dimasukkan benar dan aktif untuk keperluan komunikasi lebih lanjut.</i></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="no_tlp" class="form-control"
                            value="{{ old('no_tlp', $dataPribadi->no_tlp ?? '') }}" required>
                            <small class="form-text text-muted"><i>Masukkan nomor HP yang aktif dan terhubung dengan WhatsApp.</i></small>
                    </div>
                   
                    <div class="mb-3">
                        <label class="form-label">Password </label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <small class="form-text text-muted"><i>Password minimal 8 karakter.</i></small>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
