<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'user_id',
        'iduka_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'keterangan',
        'latitude',
        'longitude',
        'lokasi',
        'lokasi_iduka_id',
        // Add these missing fields that your controller is trying to save:
        'latitude_masuk',
        'longitude_masuk',
        'lokasi_masuk',
        'latitude_pulang', 
        'longitude_pulang',
        'lokasi_pulang',
        'jenis_izin',
        'keterangan_izin'
    ];

    protected $dates = ['tanggal'];

    // Add casts for datetime fields
    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:11',
        'latitude_masuk' => 'decimal:8',
        'longitude_masuk' => 'decimal:11',
        'latitude_pulang' => 'decimal:8',
        'longitude_pulang' => 'decimal:11'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function iduka()
    {
        return $this->belongsTo(Iduka::class);
    }

    public function lokasiIduka()
    {
        return $this->belongsTo(LokasiIduka::class, 'lokasi_iduka_id');
    }
}