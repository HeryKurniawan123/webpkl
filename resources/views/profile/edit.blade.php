@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h4 class="mb-4">Profil Saya</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row align-items-center mb-4">
                    <div class="col-auto">
                        <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/default.jpg') }}" 
                            alt="Foto Profil" 
                            class="rounded-circle shadow-sm" 
                            width="100" height="100">
                    </div>
                    <div class="col">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="profile_photo" class="form-control">
                        @error('profile_photo')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                    @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}">
                    @error('nip')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <button class="btn btn-primary btn-sm">Simpan Profil</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Ganti Password</h4>

            <form action="{{ route('profile.update.password') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control">
                    @error('current_password')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="new_password" class="form-control">
                    @error('new_password')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control">
                </div>

                <button class="btn btn-primary btn-sm">Ganti Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
