<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsulanIduka extends Model
{
    use HasFactory;
    protected $table = 'usulan_idukas';

    protected $fillable = [
        'user_id', 'konke_id','nama', 'nama_pimpinan', 'nip_pimpinan', 'jabatan',
        'alamat', 'kode_pos', 'telepon', 'email', 'bidang_industri', 'kerjasama',  'iduka_id', 'status', 'password'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // app/Models/UsulanIduka.php


public function iduka()
{
    return $this->belongsTo(Iduka::class);
}

}
