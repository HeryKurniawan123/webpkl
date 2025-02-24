<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nip',
        'kelas_id',
        'konke_id',
        'email',
        'password',
        'role',
    ];

    public function iduka()
    {
        return $this->hasOne(Iduka::class, 'user_id', 'id');
    }


    public function kependik()
    {
        return $this->hasOne(Kependik::class, 'email', 'email');
    }
    public function gurus()
    {
        return $this->hasMany(Guru::class);
    }
    public function konkes()
{
    return $this->hasOne(Konke::class, 'id', 'konkes_id');
}



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function dataPribadi()
    {
        return $this->hasOne(DataPribadi::class, 'user_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function konke()
    {
        return $this->belongsTo(Konke::class, 'konke_id'); // Perbaiki relasi
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
