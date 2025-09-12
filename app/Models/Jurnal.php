<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnals';

    protected $fillable = [
        'user_id',
        'nis',
        'tgl',
        'uraian',
        'jam_mulai',
        'jam_selesai',
        'foto',
        'status',
        'validasi_iduka',
        'validasi_pembimbing',
        'rejected_reason'
    ];

    protected $casts = [
        'tgl' => 'date',
        'approved_iduka_at' => 'datetime',
        'approved_pembimbing_at' => 'datetime',
    ];

    // Relasi dengan User - menggunakan user_id sebagai foreign key
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Jika ada relasi dengan NIS juga
    public function siswa()
    {
        return $this->belongsTo(User::class, 'nis', 'nis');
    }

    // Scope untuk filter berdasarkan validasi
    public function scopeNeedIduka($query)
    {
        return $query->where(function($q) {
            $q->where('validasi_iduka', 'belum')
              ->orWhereNull('validasi_iduka');
        });
    }

    public function scopeNeedPembimbing($query)
    {
        return $query->where(function($q) {
            $q->where('validasi_pembimbing', 'belum')
              ->orWhereNull('validasi_pembimbing');
        });
    }

    // Method untuk mengecek status approval
    public function isApprovedByIduka()
    {
        return $this->validasi_iduka === 'sudah';
    }

    public function isApprovedByPembimbing()
    {
        return $this->validasi_pembimbing === 'sudah';
    }

    public function isFullyApproved()
    {
        return $this->isApprovedByIduka() && $this->isApprovedByPembimbing();
    }

    // Boot method untuk set default values
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jurnal) {
            if (empty($jurnal->status)) {
                $jurnal->status = 'pending';
            }
            if (empty($jurnal->validasi_iduka)) {
                $jurnal->validasi_iduka = 'belum';
            }
            if (empty($jurnal->validasi_pembimbing)) {
                $jurnal->validasi_pembimbing = 'belum';
            }
        });
    }
}