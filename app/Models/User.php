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
        'tahun_ajaran',
        'role',
        'iduka_id',
        'lokasi_pkl_id',
        'profile_photo'
    ];

    // Relasi ke tabel gurus (One to One)
    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id');
    }


    // Relasi ke tabel konkes (Many to One)
    public function konke()
    {
        return $this->belongsTo(Konke::class, 'konke_id');
    }

    // Relasi ke Kelas (Many to One)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi ke Iduka (One to One)
    public function iduka()
    {
        return $this->hasOne(Iduka::class, 'user_id');
    }

    // Relasi ke Kependik (One to One, by email)
    public function kependik()
    {
        return $this->hasOne(Kependik::class, 'email', 'email');
    }

    // Relasi ke Data Pribadi (One to One)
    public function dataPribadi()
    {
        return $this->hasOne(DataPribadi::class, 'user_id');
    }


    public function dataPersuratan()
    {
        return $this->hasOne(DataPribadiPersuratan::class, 'user_id', 'id');

    }


    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembimbingpkl()
    {
        return $this->hasOne(Pembimbing::class, 'user_id', 'id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'nis', 'nip');
    }

    public function lokasiPkl()
    {
        return $this->belongsTo(LokasiPkl::class, 'lokasi_pkl_id');
    }

    public function idukaDiterima()
    {
        return $this->belongsTo(Iduka::class, 'iduka_id', 'id');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Guru::class, 'pembimbing_id');
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
}
