<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiPkl extends Model
{
    use HasFactory;

      protected $table = 'absensi_pkl';
    protected $fillable = ['user_id', 'nis', 'status', 'tipe_izin', 'waktu', 'keterangan'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'nis', 'nis');
    }
}
