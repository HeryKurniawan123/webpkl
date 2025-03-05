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

                            <form class="d-flex" style="width: 100%; max-width: 500px;">
                                <input type="text" id="searchInput" class="form-control me-2" placeholder="Cari Program Keahlian" style="flex: 1; min-width: 250px;">
                                <button type="button" class="btn btn-primary">
                                    <i class="bi bi-search"></i> 
                                </button>
                
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahProkerModal">
                                    <i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline">Tambah</span>
                                </button>
                            </div>
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
                                    <th>Program Keahlian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($proker as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProkerModal{{ $item->id }}">
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
document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#tableBody tr");
    
    rows.forEach(row => {
        let nameCell = row.cells[1]; // Kolom "Program Keahlian"
        
        if (nameCell) {
            let nameText = nameCell.textContent.toLowerCase();
            row.style.display = nameText.includes(filter) ? "" : "none";
        }
    });
});
</script>

@endsection
