@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <form action="{{ route('konke.index') }}" method="GET" class="d-flex" style="width: 100%; max-width: 500px;">
                                <input type="text" name="search" class="form-control me-2" placeholder="Cari Program Keahlian" style="flex: 1; min-width: 250px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> 
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKonkeModal">
                                Tambah Data
                            </button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Konsentrasi keahlian</th>
                                    <th>Program Keahlian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($konke as $index => $k)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $k->name_konke }}</td>
                                    <td>{{ $k->proker->name }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editKonkeModal{{ $k->id }}">
                                            <i class="bi bi-pen"></i>
                                        </button>
                                        <form action="{{ route('konke.destroy', $k->id) }}" method="POST" class="delete-btn d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

{{-- Modal Tambah Data --}}
<div class="modal fade" id="tambahKonkeModal" tabindex="-1" aria-labelledby="tambahKonkeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Tambah Konsentrasi Keahlian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('konke.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Konsentrasi Keahlian</label>
                        <input type="text" class="form-control" name="name_konke" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Program Keahlian</label>
                        <select class="form-control" name="proker_id" required>
                            <option value="">Pilih Program Keahlian</option>
                            @foreach($proker as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
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
{{-- Modal Edit Data --}}
@foreach ($konke as $k)
<div class="modal fade" id="editKonkeModal{{ $k->id }}" tabindex="-1" aria-labelledby="editKonkeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Konsentrasi Keahlian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('konke.update', $k->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Konsentrasi Keahlian</label>
                        <input type="text" class="form-control" name="name_konke" value="{{ $k->name_konke }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Program Keahlian</label>
                        <select class="form-control" name="proker_id" required>
                            <option value="">Pilih Program Keahlian</option>
                            @foreach($proker as $p)
                                <option value="{{ $p->id }}" {{ $k->proker_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
    document.querySelectorAll('.delete-btn').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); 
    
            Swal.fire({
                title: "Apakah kamu yakin?",
                text: "Data ini tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
    </script>
@endsection

