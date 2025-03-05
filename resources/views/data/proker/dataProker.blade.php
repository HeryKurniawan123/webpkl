@extends('layout.main')
@section('content')
<style>
    @media (max-width: 768px) {
        .table th:nth-child(2),
        .table td:nth-child(2) {
            min-width: 180px; 
            max-width: 100%; 
            white-space: normal; 
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    }
</style>
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Data Program Keahlian</h5>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
                                    <i class="bi bi-search"></i>
                                    <span class="d-none d-md-inline">Cari</span>
                                </button>
                
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahProkerModal">
                                    <i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline">Tambah</span>
                                </button>
                            </div>
                        </div>
                    </div>
                
                    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="searchModalLabel">Cari Program Keahlian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="#">
                                        <input type="text" name="search" class="form-control" placeholder="Cari Program Keahlian...">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif   
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        <div class="table-responsive">
                            <table class="table table-striped" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Program Keahlian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proker as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center flex-nowrap">
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
                                            </div>
                                        </td>
                                    </tr>
    
                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="editProkerModal{{ $item->id }}" tabindex="-1" aria-labelledby="editProkerModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h1 class="modal-title fs-5" id="editProkerModalLabel{{ $item->id }}">Form Edit Program Keahlian</h1>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('proker.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Program Keahlian</label>
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
                </div>

                {{-- Modal Tambah --}}
                <div class="modal fade" id="tambahProkerModal" tabindex="-1" aria-labelledby="tambahProkerModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="tambahProkerModalLabel">Form Tambah Program Keahlian</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('proker.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Program Keahlian</label>
                                    <input type="text" class="form-control" name="name" placeholder="Masukkan Program Keahlian" required>
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