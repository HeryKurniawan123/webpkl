<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CetakUsulan extends Model
{
    use HasFactory;
    protected $table = 'cetak_usulans';
    protected $fillable = [
        'siswa_id',
        'iduka_id',
        'status',
    ];
}
