<div class="modal fade" id="editDataPribadiIdukaModal" tabindex="-1" aria-labelledby="editDataPribadiIdukaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editDataPribadiIdukaModalLabel">Form Edit Data iduka</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="#" method="POST">
                <div class="modal-body">
                    <h5>Data Pribadi Iduka</h5>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Iduka</label>
                        <input type="text" class="form-control" name="nama" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="kode_pos" class="form-label">Kode Pos</label>
                        <input type="text" class="form-control" name="kode_pos" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="telepon" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password (Biarkan kosong jika tidak ingin diubah)</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div class="mb-3">
                        <label for="bidang_industri" class="form-label">Bidang Industri</label>
                        <input type="text" class="form-control" name="bidang_industri" value="" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kerjasama</label>
                        <div class="row">
                            <div class="col-md-6">
                                {{-- @php
                                $kerjasamaOptions = ['Sinkronisasi', 'Guru Tamu', 'Magang / Pelatihan', 'PKL', 'Sertifikasi'];
                                @endphp
                                @foreach($kerjasamaOptions as $option) --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kerjasama" value="" required>
                                    <label class="form-check-label"></label>
                                </div>
                                {{-- @endforeach --}}
                            </div>
                            <div class="col-md-6">
                                {{-- @php
                                $kerjasamaOptions2 = ['Tefa', 'Serapan', 'Beasiswa', 'PBL', 'Lainnya'];
                                @endphp
                                @foreach($kerjasamaOptions2 as $option) --}}
                                <div class="form-check">
                                    <input class="form-check-input kerjasama-radio" type="radio" name="kerjasama" value="">
                                    <label class="form-check-label"></label>
                                </div>
                                {{-- @endforeach --}}
                            </div>
                        </div>
                        <div class="mb-3" id="kerjasama-lainnya" style="display: none;">
                            <label class="form-label">Kerjasama (Lainnya)</label>
                            <input type="text" class="form-control" name="kerjasama_lainnya" value="" placeholder="Masukkan Jenis Kerjasama">
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_kuota_pkl" class="form-label">Jumlah Kuota PKL</label>
                            <input type="number" class="form-control" name="kuota_pkl" value="" required>
                        </div>
                    </div>
                    
                    <h5>Data Pimpinan Iduka</h5>
                    <div class="mb-3">
                        <label for="nama_pimpinan" class="form-label">Nama Pimpinan</label>
                        <input type="text" class="form-control" name="nama_pimpinan" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="nip_pimpinan" class="form-label">NIP/NIK Pimpinan</label>
                        <input type="text" class="form-control" name="nip_pimpinan" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">No HP / Telepon</label>
                        <input type="text" class="form-control" name="" value="" required>
                    </div>

                    <h5>Data Pembimbing Iduka</h5>
                    <div class="mb-3">
                        <label for="nama_pimpinan" class="form-label">Nama Pembimbing</label>
                        <input type="text" class="form-control" name="nama_pimpinan" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="nip_pimpinan" class="form-label">NIP/NIK Pembimbing</label>
                        <input type="text" class="form-control" name="nip_pimpinan" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">No HP / Telepon</label>
                        <input type="text" class="form-control" name="" value="" required>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

            // Check if "Lainnya" is already selected on page load
            if (radio.value === "Lainnya" && radio.checked) {
                lainnyaInput.style.display = "block";
            }
        });
    });
</script>