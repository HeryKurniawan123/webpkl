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
                                <input type="text" name="search" class="form-control me-2" placeholder="Cari Guru..." style="flex: 1; min-width: 250px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahGuruModal">
                                Tambah Data
                            </button>
                            
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Guru</th>
                                    <th>NIK</th>
                                    <th>NIP/NUPTK</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gurus as $guru)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $guru->nama }}</td>
                                    <td>{{ $guru->nik }}</td>
                                    <td>{{ $guru->nip }}</td>
                                    <td>{{ $guru->email }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editGuruModal{{ $guru->id }}">
                                            <i class="bi bi-pen"></i>
                                        </button>
                                       
                                    </td>
                                </tr>

                                {{-- Modal Edit --}}
                                <div class="modal fade" id="editGuruModal{{ $guru->id }}" tabindex="-1" aria-labelledby="editGuruModalLabel{{ $guru->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editGuruModalLabel{{ $guru->id }}">Form Edit Data Guru</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="#" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Guru</label>
                                                        <input type="text" class="form-control" name="nama" value="{{ $guru->nama }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NIK</label>
                                                        <input type="text" class="form-control" name="nik" value="{{ $guru->nik }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NIP/NUPTK</label>
                                                        <input type="text" class="form-control" name="nip" value="{{ $guru->nip }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tempat Lahir</label>
                                                        <input type="text" class="form-control" name="tempat_lahir" value="{{ $guru->tempat_lahir }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ $guru->tanggal_lahir }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Jenis Kelamin</label>
                                                        <select class="form-control" name="jenis_kelamin" required>
                                                            <option value="Laki-laki" {{ $guru->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                            <option value="Perempuan" {{ $guru->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat</label>
                                                        <textarea class="form-control" name="alamat" rows="3" required>{{ $guru->alamat }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Konsentrasi Keahlian</label>
                                                        <select name="konkes_id" class="form-control">
                                                            @foreach ($konkes as $konke)
                                                            <option value="{{ $konke->id }}" @if($konke->id == $guru->konkes_id) selected @endif>
                                                                {{ $konke->name_konke }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email" value="{{ $guru->email }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">No HP</label>
                                                        <input type="text" class="form-control" name="no_hp" value="{{ $guru->no_hp }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Password (Opsional)</label>
                                                        <input type="password" class="form-control" name="password">
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
                        {{ $gurus->links() }}
                    </div>
                </div>

                {{-- Modal Tambah --}}
                <div class="modal fade" id="tambahGuruModal" tabindex="-1" aria-labelledby="tambahGuruModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="tambahGuruModalLabel">Form Tambah Data Guru</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('guru.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Guru</label>
                                        <input type="text" class="form-control" name="nama" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="nik" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIP/NUPTK (opsional)</label>
                                        <input type="text" class="form-control" name="nip">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin" required>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Konsentrasi Keahlian</label>
                                        <select name="konkes_id" class="form-control">
                                            @foreach ($konkes as $konke)
                                            <option value="{{ $konke->id }}">{{ $konke->name_konke }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No HP</label>
                                        <input type="text" class="form-control" name="no_hp" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" required>
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