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
        'tanggal',
        'jenis',
        'jam',
        'latitude',
        'longitude',
        'status',
        'status_konfirmasi',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function iduka()
    {
        return $this->belongsTo(Iduka::class);
    }
}
