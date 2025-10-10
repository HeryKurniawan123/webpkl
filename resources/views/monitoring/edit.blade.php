@extends('layout.main')

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('monitoring.index') }}" class="btn btn-outline-secondary me-3">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <div>
                                <h5 class="card-title fw-bold mb-0">
                                    <i class="bx bx-edit text-warning me-2"></i>
                                    Edit Data Monitoring
                                </h5>
                                <p class="text-muted mb-0">Ubah data monitoring IDUKA</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('monitoring.update', $monitoring->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="iduka_id" class="form-label fw-semibold">
                                    <i class="bx bx-building me-1"></i> IDUKA <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('iduka_id') is-invalid @enderror" id="iduka_id"
                                    name="iduka_id" required>
                                    <option value="">Pilih IDUKA...</option>
                                    @foreach ($idukas as $iduka)
                                        <option value="{{ $iduka->id }}"
                                            {{ old('iduka_id', $monitoring->iduka_id) == $iduka->id ? 'selected' : '' }}>
                                            {{ $iduka->nama }} - {{ $iduka->alamat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('iduka_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="saran" class="form-label fw-semibold">
                                    <i class="bx bx-comment-detail me-1"></i> Saran / Catatan
                                </label>
                                <textarea class="form-control @error('saran') is-invalid @enderror" id="saran" name="saran" rows="4"
                                    placeholder="Masukkan saran atau catatan monitoring...">{{ old('saran', $monitoring->saran) }}</textarea>
                                @error('saran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Catatan hasil kunjungan atau monitoring ke IDUKA</div>
                            </div>

                            <div class="mb-3">
                                <label for="perikiraan_siswa_diterima" class="form-label fw-semibold">
                                    <i class="bx bx-user-check me-1"></i> Perkiraan Siswa Diterima
                                </label>
                                <input type="number"
                                    class="form-control @error('perikiraan_siswa_diterima') is-invalid @enderror"
                                    id="perikiraan_siswa_diterima" name="perikiraan_siswa_diterima" min="0"
                                    value="{{ old('perikiraan_siswa_diterima', $monitoring->perikiraan_siswa_diterima) }}"
                                    placeholder="Contoh: 10">
                                @error('perikiraan_siswa_diterima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Perkiraan jumlah siswa yang akan diterima di IDUKA ini</div>
                            </div>

                            <div class="mb-4">
                                <label for="foto" class="form-label fw-semibold">
                                    <i class="bx bx-camera me-1"></i> Foto Monitoring (maks 3 foto)
                                </label>

                                <input type="file" class="form-control @error('foto.*') is-invalid @enderror"
                                    id="foto" name="foto[]" accept="image/*" multiple>

                                @error('foto.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Upload sampai 3 foto (JPG, PNG, GIF, max 2MB per foto)</div>

                                {{-- Tampilkan foto lama --}}
                                @php
                                    $fotos = $monitoring->foto ? json_decode($monitoring->foto, true) : [];
                                @endphp
                                @if ($fotos)
                                    <div class="mt-3 d-flex flex-wrap gap-2">
                                        @foreach ($fotos as $foto)
                                           <img src="{{ asset($foto) }}" class="img-thumbnail" style="max-width: 180px;">
                                        @endforeach
                                    </div>
                                @endif
                            </div>


                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('monitoring.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times me-2"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i> Update Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function previewImage(inputId, previewId) {
        const input = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewId);
        const img = previewContainer.querySelector('img');

        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });
    }

    previewImage('foto1', 'preview-foto1');
    previewImage('foto2', 'preview-foto2');
    previewImage('foto3', 'preview-foto3');
</script>
