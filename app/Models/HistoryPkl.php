<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPkl extends Model
{
    use HasFactory;

    protected $table = 'history_pkl';

    protected $fillable = [
        'user_id',
        'iduka_lama_id',
        'iduka_baru_id',
        'tgl_pindah',
    ];
}
