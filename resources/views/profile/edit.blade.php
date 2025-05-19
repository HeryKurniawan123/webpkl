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
                    @if(auth()->user()->role === 'siswa')
                        <label class="form-label">NIS</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}" placeholder="Masukkan NIS">
                    @elseif(in_array(auth()->user()->role, ['iduka', 'industri']))
                        <label class="form-label">Email</label>
                        <input type="email" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}" placeholder="Masukkan email">
                    @else
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}" placeholder="Masukkan NIP">
                    @endif
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

          <!-- Password Saat Ini -->
<div class="mb-3">
    <label class="form-label">Password Saat Ini</label>
    <div class="input-group">
        <input type="password" name="current_password" class="form-control" id="current_password">
        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="current_password" tabindex="-1">
            <i class="bi bi-eye-slash"></i>
        </button>
    </div>
    @error('current_password')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<!-- Password Baru -->
<div class="mb-3">
    <label class="form-label">Password Baru</label>
    <div class="input-group">
        <input type="password" name="new_password" class="form-control" id="new_password">
        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password" tabindex="-1">
            <i class="bi bi-eye-slash"></i>
        </button>
    </div>
    @error('new_password')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<!-- Konfirmasi Password Baru -->
<div class="mb-3">
    <label class="form-label">Konfirmasi Password Baru</label>
    <div class="input-group">
        <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation">
        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password_confirmation" tabindex="-1">
            <i class="bi bi-eye-slash"></i>
        </button>
    </div>
</div>

                <button class="btn btn-primary btn-sm">Ganti Password</button>
            </form>
        </div>
    </div>
</div>

<!-- Include CropperJS CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    let cropper;
    const profilePhotoInput = document.getElementById('profilePhotoInput');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const currentPhotoContainer = document.getElementById('currentPhotoContainer');
    const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));
    const imageToCrop = document.getElementById('imageToCrop');
    const croppedImageInput = document.getElementById('croppedImageInput');

    // When file input changes
    profilePhotoInput.addEventListener('change', function(e) {
        if (e.target.files.length === 0) return;
        
        const file = e.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(event) {
            // Show the cropping modal
            imageToCrop.src = event.target.result;
            cropModal.show();
        };
        
        reader.readAsDataURL(file);
    });

    // When modal is shown, initialize cropper
    document.getElementById('cropModal').addEventListener('shown.bs.modal', function() {
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 1, // 1:1 aspect ratio
            viewMode: 1,
            autoCropArea: 0.8,
            responsive: true,
            movable: false,
            zoomable: false,
            rotatable: false,
            scalable: false
        });
    });

    // When modal is hidden, destroy cropper
    document.getElementById('cropModal').addEventListener('hidden.bs.modal', function() {
        if (cropper) {
            cropper.destroy();
        }
    });

    // Crop button click handler
    document.getElementById('cropImageBtn').addEventListener('click', function() {
        // Get cropped canvas
        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
            minWidth: 100,
            minHeight: 100,
            maxWidth: 1000,
            maxHeight: 1000,
            fillColor: '#fff',
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        if (canvas) {
            // Convert canvas to data URL
            const croppedImageUrl = canvas.toDataURL('image/jpeg');
            
            // Set the cropped image to hidden input
            croppedImageInput.value = croppedImageUrl;
            
            // Show preview
            imagePreview.innerHTML = `<img src="${croppedImageUrl}" style="width: 100%; height: 100%; object-fit: cover;">`;
            imagePreviewContainer.style.display = 'block';
            currentPhotoContainer.style.display = 'none';
            
            // Hide modal
            cropModal.hide();
        }
    });
});

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });


</script>
@endsection