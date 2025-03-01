<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPkl extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_pkl';
    protected $fillable = ['siswa_id', 'iduka_id', 'status'];

    public function dataPribadi()
    {
        return $this->belongsTo(DataPribadi::class, 'siswa_id', 'user_id');
    }
    
 

    public function iduka()
    {
        return $this->belongsTo(Iduka::class, 'iduka_id');
    }
}
