<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    public function model(array $row)
    {
        return new User([
            'name'     => $row[0], // Nama Siswa
            'nip'      => $row[1], // NIS
            'kelas' => $row[2], // Kelas
            'konke' => $row[3], // Konke
            'email'   => $row[4], // Email
            'password' => Hash::make($row[5]), // Password
            'role'     => 'siswa', // Set peran sebagai 'siswa'
        ]);
    }
}
