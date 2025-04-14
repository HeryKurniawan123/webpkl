@extends('layout.main')
@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card-header" style="background-color: #7e7dfb">
                    <h5 style="color: white;">Form Usulan Iduka Baru</h5>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('usulan.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Iduka</label>
                                <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Iduka" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pimpinan</label>
                                <input type="text" class="form-control" name="nama_pimpinan" placeholder="Masukkan Nama Pimpinan" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIP/NIK Pimpinan</label>
                                <input type="text" class="form-control" name="nip_pimpinan" placeholder="Masukkan NIP/NIK Pimpinan" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" placeholder="Masukkan Jabatan" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat Lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" name="kode_pos" placeholder="Masukkan Kode Pos" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon (Kantor / Perusahaan)</label>
                                <input type="number" class="form-control" name="telepon" placeholder="Masukkan Nomor Telepon" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                            </div>
                            <div class="mb-3">
    <label for="password" class="form-label">Password untuk Akun IDUKA</label>
    <input type="password" name="password" id="password" class="form-control" required minlength="6">
</div>

                            <div class="mb-3">
                                <label class="form-label">Bidang Industri</label>
                                <input type="text" class="form-control" name="bidang_industri" placeholder="Masukkan Bidang Industri" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kerjasama</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        @php
                                            $kerjasamaOptions = ['Sinkronisasi', 'Guru Tamu', 'Magang / Pelatihan', 'PKL', 'Sertifikasi'];
                                        @endphp
                                        @foreach($kerjasamaOptions as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kerjasama" value="{{ $option }}" required>
                                                <label class="form-check-label">{{ $option }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        @php
                                            $kerjasamaOptions2 = ['Tefa', 'Serapan', 'Beasiswa', 'PBL', 'Lainnya'];
                                        @endphp
                                        @foreach($kerjasamaOptions2 as $option)
                                            <div class="form-check">
                                                <input class="form-check-input kerjasama-radio" type="radio" name="kerjasama" value="{{ $option }}">
                                                <label class="form-check-label">{{ $option }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" id="kerjasama-lainnya" style="display: none;">
                                <label class="form-label">Kerjasama (Lainnya)</label>
                                <input type="text" class="form-control" name="kerjasama_lainnya" placeholder="Masukkan Jenis Kerjasama">
                            </div>

                            <!-- Field status default 'proses' -->
                            <input type="hidden" name="status" value="proses">

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let radios = document.querySelectorAll('.kerjasama-radio');
        let lainnyaInput = document.getElementById('kerjasama-lainnya');

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === "Lainnya") {
                    lainnyaInput.style.display = "block";
                } else {
                    lainnyaInput.style.display = "none";
                }
            });
        });
    });
</script>
@endsection
