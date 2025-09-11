<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $table = 'jurnals';

    protected $fillable = [
        'nis',
        'tgl',
        'uraian',
        'jam_mulai',
        'jam_selesai',
        'validasi_iduka',
        'validasi_pembimbing',
        'foto'
    ];

    protected $casts = [
        'tgl' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    // Relasi ke tabel siswa (jika diperlukan)
    public function siswa()
    {
        return $this->belongsTo(User::class, 'nis', 'nis');
    }
}
