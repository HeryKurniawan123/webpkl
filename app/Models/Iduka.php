<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iduka extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'user_id',
        'nama_pimpinan',
        'nip_pimpinan',
        'jabatan',
        'alamat',
        'kode_pos',
        'telepon',
        'email',
        'password',
        'bidang_industri',
        'kerjasama',
        'kerjasama_lainnya',
        'kuota_pkl',
        'rekomendasi',
        'no_hp_pimpinan',
    ];


    public function usulan()
    {
        return $this->hasOne(UsulanIduka::class, 'iduka_id');
    }
    

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}


    public function pembimbing()
    {
        return $this->hasMany(Pembimbing::class, 'user_id');
    }
    
    public function atps()
    {
        return $this->belongsToMany(Atp::class, 'iduka_atps')->withPivot('cp_id')->withTimestamps();
    }
    // Relasi ke Kompetensi Keahlian (Konkes)
    public function konkes()
    {
        return $this->belongsToMany(Konke::class, 'iduka_atps', 'iduka_id', 'konkes_id');
    }

     // Relasi ke CP (Capaian Pembelajaran)
     public function cps()
     {
         return $this->belongsToMany(Cp::class, 'iduka_atps', 'iduka_id', 'cp_id');
     }
 
    
    


}
