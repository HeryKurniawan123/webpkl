<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'nik',
        'nip',
        'email',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'password',
        'konke_id',
        'user_id',
    ];
    protected $hidden = [
        'password',
    ];
    // Relasi ke Proker (Many to One)
    public function proker()
    {
        return $this->belongsTo(Proker::class, 'konke_id', 'id');
    }

    // Relasi ke Guru (One to Many)
    public function gurus()
    {
        return $this->hasMany(Guru::class, 'konke_id');
    }

    // Relasi ke CP (One to Many)
    public function cp()
    {
        return $this->hasMany(Cp::class, 'konke_id');
    }

    // Relasi ke Data Pribadi (One to Many)
    public function dataPribadis()
    {
        return $this->hasMany(DataPribadi::class, 'konke_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function konke()
    {
        return $this->belongsTo(Konke::class, 'konke_id', 'id');
    }

    public function siswas()
    {
        return $this->belongsToMany(User::class, 'pembimbing_siswa', 'guru_id', 'siswa_id');
    }
}
