<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\User;

class PembimbingDataController extends Controller
{
    // Halaman daftar siswa yang dibimbing oleh pembimbing login
    public function index()
    {
        // ambil guru yang login sekarang
        $guru = Guru::where('user_id', Auth::id())->first();

        if (!$guru) {
            abort(404, 'Data pembimbing tidak ditemukan.');
        }

        // ambil siswa yang dibimbing oleh guru ini
        $siswas = User::where('konke_id', $guru->konke_id)
            ->where('role', 'siswa')
            ->get();

        return view('guru.siswa-dibimbing.index', compact('guru', 'siswas'));
    }
}
