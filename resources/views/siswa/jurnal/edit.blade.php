<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tgl" value="{{ $jurnal->tgl }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">Foto Kegiatan</label>
            <input type="file" class="form-control" name="foto" accept="image/*">
            @if($jurnal->foto)
                <small class="text-muted">Foto saat ini: 
                    <a href="{{ $jurnal->foto }}" target="_blank">Lihat foto</a>
                </small>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">Jam Mulai</label>
            <input type="time" class="form-control" name="jam_mulai" value="{{ $jurnal->jam_mulai }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">Jam Selesai</label>
            <input type="time" class="form-control" name="jam_selesai" value="{{ $jurnal->jam_selesai }}" required>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="form-label">Uraian Kegiatan</label>
    <textarea class="form-control" name="uraian" rows="5" required>{{ $jurnal->uraian }}</textarea>
</div>

@if($jurnal->foto)
    <div class="form-group">
        <label class="form-label">Foto Saat Ini</label>
        <div class="text-center">
            <img src="{{ $jurnal->foto }}" 
                 alt="Foto Kegiatan" 
                 class="img-fluid rounded shadow-sm"
                 style="max-height: 200px; object-fit: cover;">
        </div>
        <small class="text-muted">Upload foto baru jika ingin mengganti foto yang ada</small>
    </div>
@endif