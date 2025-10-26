<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PindahPkl extends Model
{
    protected $table = 'pindah_pkl';
    protected $fillable = ['siswa_id', 'iduka_id', 'iduka_baru_id', 'konke_id', 'status'];

    // Relasi ke tempat PKL lama
    public function idukaLama()
    {
        return $this->belongsTo(Iduka::class, 'iduka_id'); // kolom lama
    }

    // Relasi ke tempat PKL baru (jika ada)
    public function idukaBaru()
    {
        return $this->belongsTo(Iduka::class, 'iduka_baru_id'); // kolom baru
    }

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
