@extends('layout.main')
@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <form action="{{ route('proker.index') }}" method="GET" class="d-flex" style="width: 100%; max-width: 500px;">
                                <input type="text" name="search" class="form-control me-2" placeholder="Cari Program Kerja" style="flex: 1; min-width: 250px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> 
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahProkerModal">
                                Tambah Data
                            </button>
                        </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Program Kerja</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proker as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editProkerModal{{ $item->id }}">
                                            <i class="bi bi-pen"></i>
                                        </button>
                                        <form action="{{ route('proker.destroy', $item->id) }}" method="POST" class="delete-btn d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Modal Edit --}}
                                <div class="modal fade" id="editProkerModal{{ $item->id }}" tabindex="-1" aria-labelledby="editProkerModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="editProkerModalLabel{{ $item->id }}">Form Edit Program Kerja</h1>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('proker.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Program Kerja</label>
                                                    <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
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
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Modal Tambah --}}
                <div class="modal fade" id="tambahProkerModal" tabindex="-1" aria-labelledby="tambahProkerModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="tambahProkerModalLabel">Form Tambah Program Kerja</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('proker.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Program Kerja</label>
                                    <input type="text" class="form-control" name="name" placeholder="Masukkan Program Kerja" required>
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

            </div>
        </div>
    </div>
</div>

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