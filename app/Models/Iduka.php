<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iduka extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
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
    ];

      public function user()
      {
          return $this->hasOne(User::class, 'nip', 'email');
      }
}
