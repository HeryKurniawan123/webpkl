<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdukaAtp extends Model
{
    use HasFactory;
    protected $fillable = ['iduka_id', 'cp_id', 'atp_id','is_selected','konkes_id'];

    public function iduka()
    {
        return $this->belongsTo(Iduka::class);
    }

    public function cp()
    {
        return $this->belongsTo(Cp::class);
    }

    public function atp()
    {
        return $this->belongsTo(Atp::class);
    }
    public function konke()
    {
        return $this->belongsTo(Konke::class, 'konkes_id');
    }
}
