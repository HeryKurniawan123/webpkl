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
        'konkes_id',
    ];
    protected $hidden = [
        'password',
    ];
    public function konke()
    {
        return $this->belongsTo(Konke::class, 'konkes_id', 'id');
    }
}
