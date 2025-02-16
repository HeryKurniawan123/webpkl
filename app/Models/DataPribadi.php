<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPribadi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'nip',
        'konsentrasi_keahlian',
        'kelas',
        'email',
        'name_ayh',
        'name_ibu',
        'nik',
        'alamat',
        'email_ortu',
        'no_tlp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
