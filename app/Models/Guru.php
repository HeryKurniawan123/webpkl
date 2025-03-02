<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nik',
        'nip',
        'email',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'password',
        'konkes_id',
        'user_id',
    ];
    protected $hidden = [
        'password',
    ];
    // Relasi ke Proker (Many to One)
    public function proker()
    {
        return $this->belongsTo(Proker::class);
    }

    // Relasi ke Guru (One to Many)
    public function gurus()
    {
        return $this->hasMany(Guru::class, 'konkes_id');
    }

    // Relasi ke CP (One to Many)
    public function cp()
    {
        return $this->hasMany(Cp::class, 'konkes_id');
    }

    // Relasi ke Data Pribadi (One to Many)
    public function dataPribadis()
    {
        return $this->hasMany(DataPribadi::class, 'konkes_id');
    }
}
