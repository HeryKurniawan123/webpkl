<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konke extends Model
{
    use HasFactory;
    protected $table = 'konkes';

    protected $fillable = ['name_konke', 'proker_id'];

    public function proker()
    {
        return $this->belongsTo(Proker::class);
    }

    public function gurus()
{
    return $this->hasMany(Guru::class, 'konkes_id', 'id');
}


}
