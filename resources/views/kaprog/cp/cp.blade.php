@extends('layout.main')

@section('content')
    <div class="container mt-4">

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form Pencarian dan Tombol Tambah --}}
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <form action="{{ route('cp.index') }}" method="GET" class="d-flex" style="width: 100%; max-width: 500px;">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari Tujuan Pembelajaran..." value="{{ request('search') }}" style="flex: 1; min-width: 250px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahCpTpModal">Tambah CP & TP</button>
                </div>
            </div>
        </div>

        {{-- Menampilkan CP dan ATP --}}
        @foreach ($cp as $item)
            <div class="card card-content mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>Konsentrasi: {{ $item->konke->name_konke }}</h4>
                        <h5>{{ $item->cp }}</h5>
                    </div>

                    <div>
                        {{-- Tombol Edit --}}
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTpModal-{{ $item->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        {{-- Tombol Hapus --}}
                        <form id="delete-form-{{ $item->id }}" action="{{ route('cp.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $item->id }}')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>                        
                    </div>
                </div>

                {{-- Daftar ATP --}}
                <div class="card-body">
                    <ul>
                        @foreach ($item->atp as $atp)
                            <li>{{ $atp->kode_atp }} - {{ $atp->atp }}</li>
                        @endforeach
                    </ul>
                </div>
                
            </div>
            {{-- Modal Edit CP & ATP --}}
            <div class="modal fade" id="editTpModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editTpModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('cp.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit CP dan ATP</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                {{-- Input CP --}}
                                <div class="mb-3">
                                    <label for="cp" class="form-label">Deskripsi CP</label>
                                    <input type="text" class="form-control" name="cp" value="{{ $item->cp }}" required>
                                </div>

                                {{-- Input ATP --}}
                                <label class="form-label">Tujuan Pembelajaran (ATP)</label>
                                <div id="tpFieldsEdit-{{ $item->id }}">
                                    @foreach($item->atp as $atp)
                                        <div class="input-group mb-2">
                                            <input type="text" name="atp[]" class="form-control" value="{{ $atp->atp }}" required>
                                            <button type="button" class="btn btn-secondary" onclick="removeTpField(this)">-</button>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addTpField('tpFieldsEdit-{{ $item->id }}')">
                                    + Tambah ATP
                                </button>
                            </div>

                            {{-- Tombol Simpan --}}
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- Modal Tambah CP & ATP --}}
<div class="modal fade" id="tambahCpTpModal" tabindex="-1" aria-labelledby="tambahCpTpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('cp.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah CP dan ATP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- Input CP --}}
                    <div class="mb-3">
                        <label for="cp" class="form-label">CP (Capaian Pembelajaran)</label>
                        <input type="text" class="form-control" name="cp" value="{{ old('cp') }}" required placeholder="Masukkan CP">
                    </div>

                    {{-- Input ATP --}}
                    <label class="form-label">Tujuan Pembelajaran (ATP)</label>
                    <div id="tpFieldsTambah">
                        <div class="input-group mb-2">
                            <input type="text" name="atp[]" class="form-control" placeholder="Masukkan ATP" required>
                            <button type="button" class="btn btn-secondary" onclick="removeTpField(this)">-</button>
                        </div>
                    </div>

                    {{-- Tombol Tambah ATP --}}
                    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addTpField('tpFieldsTambah')">
                        + Tambah ATP
                    </button>
                </div>

                {{-- Tombol Simpan --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>


    </div>

    <script>
        function addTpField(containerId) {
            let container = document.getElementById(containerId);
            let newField = document.createElement("div");
            newField.classList.add("input-group", "mb-2");
            newField.innerHTML = `
                <input type="text" name="atp[]" class="form-control" placeholder="Masukkan ATP" required>
                <button type="button" class="btn btn-secondary" onclick="removeTpField(this)">-</button>
            `;
            container.appendChild(newField);
        }
    
        function removeTpField(button) {
            button.parentElement.remove();
        }
    </script>
    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
    @endif

    
@endsection
