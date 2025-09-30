<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiPending extends Model
{
    use HasFactory;

    protected $table = 'absensi_pending';

    protected $fillable = [
        'user_id',
        'iduka_id',
        'pembimbing_id',
        'tanggal',
        'jenis',
        'jam',
        'latitude',
        'longitude',
        'status',
        'status_konfirmasi',
        'validasi_iduka',           // TAMBAHAN BARU
        'validasi_pembimbing',
        'approved_iduka_at',        // TAMBAHAN BARU
        'approved_pembimbing_at',
        'alasan_penolakan',         // TAMBAHAN BARU
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam' => 'datetime',
        'approved_iduka_at' => 'datetime',      // TAMBAHAN BARU
        'approved_pembimbing_at' => 'datetime',
    ];

    // Relasi ke User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke IDUKA
    public function iduka()
    {
        return $this->belongsTo(Iduka::class);
    }

    // Relasi ke Guru (Pembimbing) - PENTING: Ini harus ke tabel gurus, bukan users
    public function pembimbing()
    {
        return $this->belongsTo(Guru::class, 'pembimbing_id');
    }

    // Scope untuk filter data hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', today());
    }

    // Scope untuk filter status pending
    public function scopePending($query)
    {
        return $query->where('status_konfirmasi', 'pending');
    }

    // Scope untuk filter jenis absensi (masuk/pulang)
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    // Scope untuk absensi yang menunggu approval IDUKA
    public function scopeMenungguIduka($query)
    {
        return $query->where('validasi_iduka', 'pending');
    }

    // Scope untuk absensi yang menunggu approval Pembimbing
    public function scopeMenungguPembimbing($query)
    {
        return $query->where('validasi_pembimbing', 'pending');
    }

    // Scope untuk absensi yang kedua pihak sudah approve
    public function scopeBothApproved($query)
    {
        return $query->where('validasi_iduka', 'disetujui')
            ->where('validasi_pembimbing', 'disetujui');
    }

    // Helper method untuk cek apakah sudah fully approved
    public function isFullyApproved()
    {
        return $this->validasi_iduka === 'disetujui' &&
            $this->validasi_pembimbing === 'disetujui';
    }

    // Helper method untuk cek apakah ada penolakan
    public function isRejected()
    {
        return $this->validasi_iduka === 'ditolak' ||
            $this->validasi_pembimbing === 'ditolak';
    }

    // Di model AbsensiPending
    protected $attributes = [
        'validasi_iduka' => 'pending',
        'validasi_pembimbing' => 'pending',
        'status_konfirmasi' => 'pending'
    ];

    // Tambahkan mutator untuk memastikan nilai tidak null
    public function setValidasiIdukaAttribute($value)
    {
        $this->attributes['validasi_iduka'] = $value ?: 'pending';
    }

    public function setValidasiPembimbingAttribute($value)
    {
        $this->attributes['validasi_pembimbing'] = $value ?: 'pending';
    }
}
