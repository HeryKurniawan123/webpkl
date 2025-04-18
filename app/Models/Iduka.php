<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iduka extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'user_id',
        'nama_pimpinan',
        'nip_pimpinan',
        'jabatan',
        'alamat',
        'kode_pos',
        'telepon',
        'email',
        'password',
        'bidang_industri',
        'kerjasama',
        'kerjasama_lainnya',
        'kuota_pkl',
        'rekomendasi',
        'no_hp_pimpinan',
    ];


    public function usulan()
    {
        return $this->hasOne(UsulanIduka::class, 'iduka_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function pembimbing()
    {
        return $this->hasMany(Pembimbing::class, 'user_id');
    }

    // Model: Iduka.php
    public function atps()
    {
        return $this->hasMany(IdukaAtp::class, 'iduka_id');
    }

    // Relasi ke Kompetensi Keahlian (Konkes)
    public function konkes()
    {
        return $this->belongsToMany(Konke::class, 'iduka_atps', 'iduka_id', 'konke_id');
    }

    // Relasi ke CP (Capaian Pembelajaran)
   // IdukaAtp.php

public function cp()
{
    return $this->belongsTo(Cp::class);
}

public function atp()
{
    return $this->belongsTo(Atp::class);
}


    public function pengajuanUsulans()
    {
        return $this->hasMany(PengajuanUsulan::class, 'iduka_id');
    }
}
