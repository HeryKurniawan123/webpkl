<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdukaAtp extends Model
{
    use HasFactory;
    protected $fillable = ['iduka_id', 'cp_id', 'atp_id'];

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
}
