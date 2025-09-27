<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;

    protected $table = 'monitoring';

    protected $fillable = [
        'iduka_id',
        'saran',
        'perikiraan_siswa_diterima',
        'foto',
    ];

    /**
     * Relationship with Iduka
     */
    public function iduka()
    {
        return $this->belongsTo(Iduka::class, 'iduka_id');
    }
}