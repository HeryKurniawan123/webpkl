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




    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembimbing()
    {
        return $this->hasMany(Pembimbing::class, 'user_id');
    }
    


}
