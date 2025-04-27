<div class="modal fade" id="editDataPribadiIdukaModal" tabindex="-1" aria-labelledby="editDataPribadiIdukaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editDataPribadiIdukaModalLabel">Form Edit Data Institusi / Perusahaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- SATU FORM UNTUK SEMUA DATA -->
            <form action="{{ route('iduka.updatePribadi', $iduka->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <h5>Data Pribadi Institusi</h5>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Institusi</label>
                        <input type="text" class="form-control" name="nama" value="{{ $iduka->nama }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <input type="text" class="form-control" name="alamat" value="{{ $iduka->alamat }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="kode_pos" class="form-label">Kode Pos</label>
                        <input type="text" class="form-control" name="kode_pos" value="{{ $iduka->kode_pos }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="telepon" value="{{ $iduka->telepon }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $iduka->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password (Biarkan kosong jika tidak ingin diubah)</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    
                    <div class="mb-3">
                        <label for="bidang_industri" class="form-label">Bidang Industri</label>
                        <input type="text" class="form-control" name="bidang_industri" value="{{ $iduka->bidang_industri }}" required>
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
                                    <input class="form-check-input" type="radio" name="kerjasama" value="{{ $option }}"
                                        {{ $iduka->kerjasama == $option ? 'checked' : '' }} required>
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
                                    <input class="form-check-input kerjasama-radio" type="radio" name="kerjasama" value="{{ $option }}"
                                        {{$iduka->kerjasama == $option ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $option }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    
                        <div class="mb-3" id="kerjasama-lainnya" style="display: {{$iduka->kerjasama == 'Lainnya' ? 'block' : 'none' }};">
                            <label class="form-label">Kerjasama (Lainnya)</label>
                            <input type="text" class="form-control" name="kerjasama_lainnya" 
                                   value="{{$iduka->kerjasama_lainnya }}" placeholder="Masukkan Jenis Kerjasama">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jumlah_kuota_pkl" class="form-label">Jumlah Kuota PKL</label>
                        <input type="number" class="form-control" name="kuota_pkl" value="{{  $iduka->kuota_pkl }}" required>
                    </div>
                    
                    <h5>Data Pimpinan Institusi</h5>
                    
                    <div class="mb-3">
                        <label for="nama_pimpinan" class="form-label">Nama Pimpinan</label>
                        <input type="text" class="form-control" name="nama_pimpinan" value="{{ $iduka->nama_pimpinan }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nip_pimpinan" class="form-label">NIP/NIK Pimpinan</label>
                        <input type="text" class="form-control" name="nip_pimpinan" value="{{  $iduka->nip_pimpinan }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" value="{{ $iduka->jabatan }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="no_hp_pimpinan" class="form-label">No HP / Telepon</label>
                        <input type="text" class="form-control" name="no_hp_pimpinan" value="{{$iduka->no_hp_pimpinan }}" required>
                    </div>
                    

                    <h5>Data Pembimbing Institusi</h5>
                    <div class="mb-3">
                        <label class="form-label">Nama Pembimbing</label>
                        <input type="text" name="nama_pembimbing" class="form-control"
                            value="{{$pembimbing->name ?? '' }}" required>
                    </div>
                
                    <div class="mb-3">
                        <label class="form-label">NIP Pembimbing</label>
                        <input type="text" name="nip_pembimbing" class="form-control"
                            value="{{ $pembimbing->nip ?? ''}}" required>
                    </div>
                
                    <div class="mb-3">
                        <label class="form-label">No HP Pembimbing</label>
                        <input type="text" name="no_hp_pembimbing" class="form-control"
                            value="{{  $pembimbing->no_hp ?? '' }}" required>
                    </div>
                

                    <div class="mb-3">
                        <label class="form-label">Password Pembimbing (Opsional)</label>
                        <input type="password" class="form-control" name="password_pembimbing" placeholder="Isi jika ingin mengganti">
                    </div>
                </div>

                <!-- Tombol submit harus ada dalam form -->
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