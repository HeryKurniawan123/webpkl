<div class="modal fade" id="tambahIdukaModal" tabindex="-1" aria-labelledby="tambahIdukaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('iduka.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahIdukaModalLabel">Form Tambah Data Industri Dunia Kerja</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                        <input type="text" class="form-control" name="nip_pimpinan" placeholder="Masukkan Nip/Nik Pimpinan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon Pimpinan</label>
                        <input type="text" class="form-control" name="no_hp_pimpinan" placeholder="Masukkan Nomor Telepon Pimpinan" required>
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
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
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
                    <div class="mb-3">
                        <label class="form-label">Jumlah Kuota PKL</label>
                        <input type="number" class="form-control" name="kuota_pkl" placeholder="Masukkan Kuota PKL" required>
                    </div>
                    <div class="mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="rekomendasi" name="rekomendasi" value="1">
        <label class="form-check-label" for="rekomendasi">
            Saya merekomendasikan IDUKA ini
        </label>
    </div>
</div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let kerjasamaRadios = document.querySelectorAll(".kerjasama-radio");
        let lainnyaInput = document.getElementById("kerjasama-lainnya");

        kerjasamaRadios.forEach(radio => {
            radio.addEventListener("change", function() {
                if (this.value === "Lainnya") {
                    lainnyaInput.style.display = "block";
                } else {
                    lainnyaInput.style.display = "none";
                }
            });
        });
    });
</script>