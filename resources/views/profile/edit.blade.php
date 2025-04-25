@extends('layout.main')

@section('content')
<div class="container">
    <h2>Profil Saya</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
       
   
        <div class="mb-3">
            <label>Foto Profil</label><br>
            <img src="{{ $user->profile_photo_url }}" width="100" class="rounded-circle mb-2" >
            <input type="file" name="profile_photo" class="form-control">
         
            @error('profile_photo')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/default.jpg') }}" 
            alt="Foto Profil" 
          
            width="100" 
            height="100">
        </div>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label>NIP</label>
            <input type="nip" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}">
            @error('nip')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary">Simpan Profil</button>
    </form>

    <hr>

    <h4>Ganti Password</h4>
    <form action="{{ route('profile.update.password') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Password Saat Ini</label>
            <input type="password" name="current_password" class="form-control">
            @error('current_password')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="new_password" class="form-control">
            @error('new_password')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="form-control">
        </div>

        <button class="btn btn-warning">Ganti Password</button>
    </form>
</div>
@endsection
