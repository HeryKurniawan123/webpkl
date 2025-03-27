<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanUsulan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'konke_id',
        'iduka_id',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function dataPribadi()
    {
        return $this->hasOneThrough(DataPribadi::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }

    public function iduka()
    {
        return $this->belongsTo(Iduka::class, 'iduka_id');
    }
}
