@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Pengajuan PKL</h5>
                        <button id="btn-select-mode" class="btn btn-warning me-2">Pilih Siswa</button>

                        <form id="form-cetak" action="{{ route('persuratan.suratPengantar.cetakPilihan') }}" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="iduka_id" value="{{ $iduka_id }}">
                            <button id="btn-cetak" type="submit" class="btn btn-success" style="display: none;">Cetak Surat Pilihan</button>
                        </form>

                        @if($pengajuanUsulans->isNotEmpty())
                        <a href="{{ route('semua.surat.pdf', $iduka_id) }}" class="btn btn-success">
                            Unduh Surat Pengantar
                        </a>
                    </div>
                    @endif

                </div>
            </div>
            <div class="col-md-12 mt-3">
                @if($pengajuanUsulans->isEmpty())
                <p class="text-center">Tidak ada pengajuan yang tersedia untuk Institusi ini.</p>
                @else
                {{-- Looping Daftar Siswa --}}
                @foreach($pengajuanUsulans as $pengajuan)
                <div class="card mb-3 shadow-sm" style="padding: 20px; border-radius: 10px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="selected_siswa[]" value="{{ $pengajuan->id }}" class="form-check-input me-3 checkbox-siswa" style="display: none;">
                            <div>
                                <div class="mb-0" style="font-size: 18px">
                                    <strong>{{ $pengajuan->dataPribadi->name ?? 'Nama Tidak Tersedia' }}</strong>
                                </div>
                                <div>
                                    Kelas: {{ $pengajuan->dataPribadi->kelas->kelas ?? '-' }} {{ $pengajuan->dataPribadi->kelas->name_kelas ?? '-' }}
                                </div>
                                <div>
                                    Status: {{ ucfirst($pengajuan->status) }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('persuratan.suratPengajuan.detailSuratPengajuan', $pengajuan->id) }}" class="btn btn-info">
                                Lihat Detail
                            </a>
                            @if($pengajuan->status === 'sudah')
                            <button class="btn btn-success" disabled>Sudah</button>
                            @else
                            <button class="btn btn-primary btn-proses" data-id="{{ $pengajuan->id }}">Kirim</button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-proses');
        const selectButton = document.getElementById('btn-select-mode');
        const cetakButton = document.getElementById('btn-cetak');
        const checkboxes = document.querySelectorAll('.checkbox-siswa');
        const formCetak = document.getElementById('form-cetak');
        let selectModeActive = false; // Tambah variabel untuk mode

        selectButton.addEventListener('click', function(e) {
            e.preventDefault();
            selectModeActive = !selectModeActive; // Toggle mode

            if (selectModeActive) {
                checkboxes.forEach(cb => cb.style.display = 'block');
                cetakButton.style.display = 'inline-block';
                selectButton.textContent = 'Batal Pilih'; // Ganti teks tombol
                selectButton.classList.remove('btn-warning');
                selectButton.classList.add('btn-secondary');
            } else {
                checkboxes.forEach(cb => {
                    cb.style.display = 'none';
                    cb.checked = false; // Uncheck semua saat batal
                });
                cetakButton.style.display = 'none';
                selectButton.textContent = 'Pilih Siswa'; // Balik teks tombol
                selectButton.classList.remove('btn-secondary');
                selectButton.classList.add('btn-warning');
            }
        });

        formCetak.addEventListener('submit', function(e) {
            // Hapus input hidden lama (kalau ada)
            formCetak.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());

            // Ambil semua checkbox yang dicentang
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'ids[]';
                    hiddenInput.value = cb.value;
                    formCetak.appendChild(hiddenInput);
                }
            });

            // Kalau tidak ada yang dipilih, cancel submit
            if (formCetak.querySelectorAll('input[name="ids[]"]').length === 0) {
                e.preventDefault();
                Swal.fire('Pilih minimal satu siswa!', '', 'warning');
            }
        });

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const buttonRef = this;

                Swal.fire({
                    title: 'Apakah surat pengantar sudah di print?',
                    text: "Data akan dikirim ke Kaprog!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Sudah!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(`/review/pengajuan/proses/${id}`)
                            .then(response => {
                                Swal.fire({
                                    title: 'Data berhasil dikirim!',
                                    text: response.data.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Ubah tombol
                                buttonRef.textContent = 'Sudah';
                                buttonRef.disabled = true;
                                buttonRef.classList.remove('btn-primary');
                                buttonRef.classList.add('btn-success');
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat memproses.',
                                    icon: 'error'
                                });
                            });
                    }
                });
            });
        });
    });
</script>
@endpush