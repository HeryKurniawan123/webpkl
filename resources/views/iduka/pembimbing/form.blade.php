@extends('layout.main')
@section('content')
    <div class="container-fluid"><br>
        <div class="card shadow mb-4">
            <div class="card-body">
                <h1 class="h3 mb-2 text-gray-800">Data Diri Pembimbing</h1>

                @if (session('success'))
                    <p style="color: green;">{{ session('success') }}</p>
                @endif

                @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ !isset($pembimbing->id) ? route('iduka.pembimbing.store') : route('iduka.pembimbing.update', $pembimbing->id) }}" method="POST">
                    @csrf
                    @if(isset($pembimbing->id)) 
                        @method('PUT') {{-- Gunakan PUT hanya untuk update --}}
                    @endif
                
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control"
                        value="{{ old('name', $pembimbing->name ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control"
                            value="{{ old('nip', $pembimbing->nip ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="text" name="no_hp" class="form-control"
                        value="{{ old('no_hp', $pembimbing->no_hp ?? '') }}" required>
                    </div>
        
                    <div class="mb-3">
                        <label class="form-label">Password </label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
