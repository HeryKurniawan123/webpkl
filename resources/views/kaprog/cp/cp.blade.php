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

    {{-- Menampilkan CP dan ATP dalam satu card per konsentrasi --}}
    @foreach ($konke as $konsentrasi)
    <div class="card mt-3">
        <div class="card-header">
            <h4>Konsentrasi: {{ $konsentrasi->name_konke }}</h4>
        </div>

        <div class="card-body">
            @foreach ($konsentrasi->cp as $index => $item)
            <div class="mb-3">
                <h5>{{ $index + 1 }}. {{ $item->cp }}</h5>
                <ul>
                    @foreach ($item->atp as $atpIndex => $atp)
                    <li>{{ $index + 1 }}.{{ $atpIndex + 1 }} - {{ $atp->atp }}</li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <div class="card-footer">
            {{-- Tombol Edit dan Hapus untuk Konsentrasi --}}
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCpModal-{{ $konsentrasi->id }}">
                <i class="bi bi-pencil-square"></i> Edit
            </button>
            
            <form id="delete-form-{{ $konsentrasi->id }}" action="{{ route('cp.destroy', $konsentrasi->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $konsentrasi->id }}')">
                    <i class="bi bi-trash3"></i> Hapus
                </button>
            </form>
        </div>
    </div>
    @endforeach


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

{{-- Modal Tambah CP & ATP --}}
<!-- Modal Tambah CP & ATP -->
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
                    <div id="cpContainer">
                        <!-- CP & ATP akan ditambahkan di sini -->
                    </div>

                    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addCpField()">
                        + Tambah CP
                    </button>
                </div>

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
    let cpIndex = 0;

    function addCpField() {
        cpIndex++;
        let cpContainer = document.getElementById("cpContainer");
        let newCpField = document.createElement("div");
        newCpField.classList.add("mb-3", "border", "p-3", "rounded");
        newCpField.innerHTML = `
            <label class="form-label">CP ke- ${cpIndex}</label>
            <input type="text" class="form-control mb-2" name="cp[]" required placeholder="Masukkan CP">
            <div id="tpFields-${cpIndex}">
                <label class="form-label">Tujuan Pembelajaran (ATP)</label>
                <div class="input-group mb-2">
                    <input type="text" name="atp[${cpIndex}][]" class="form-control" placeholder="Masukkan ATP" required>
                    <button type="button" class="btn btn-secondary" onclick="removeField(this)">-</button>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addTpField(${cpIndex})">
                + Tambah ATP
            </button>
        `;
        cpContainer.appendChild(newCpField);
    }

    function addTpField(cpIdx) {
        let tpContainer = document.getElementById(`tpFields-${cpIdx}`);
        let newTpField = document.createElement("div");
        newTpField.classList.add("input-group", "mb-2");
        newTpField.innerHTML = `
            <input type="text" name="atp[${cpIdx}][]" class="form-control" placeholder="Masukkan ATP" required>
            <button type="button" class="btn btn-secondary" onclick="removeField(this)">-</button>
        `;
        tpContainer.appendChild(newTpField);
    }

    function removeField(button) {
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
        text: '{{ session('
        success ') }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false
    });
</script>
@endif


@endsection