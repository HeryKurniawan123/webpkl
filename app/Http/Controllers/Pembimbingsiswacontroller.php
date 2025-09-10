<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembimbingSiswaController extends Controller
{
    // Daftar semua pembimbing
    public function index()
    {
        $pembimbings = Guru::with('konke')->paginate(6);
        $siswas = User::where('role', 'siswa')->get();

        return view('pembimbing_siswa.index', compact('pembimbings', 'siswas'));
    }

    // Lihat detail pembimbing
    public function show($id)
    {
        $pembimbing = Guru::with('siswas')->findOrFail($id);

        // siswa yang belum punya pembimbing
        $siswas = User::where('role', 'siswa')
            ->whereNull('pembimbing_id')
            ->get();

        return view('pembimbing_siswa.show', compact('pembimbing', 'siswas'));
    }

    public function store(Request $request, $pembimbingId)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
        ]);

        // cek apakah siswa sudah punya pembimbing
        $siswa = User::where('role', 'siswa')->findOrFail($request->siswa_id);

        if ($siswa->pembimbing_id) {
            return back()->with('error', 'Siswa ini sudah memiliki pembimbing.');
        }

        // assign pembimbing
        $siswa->pembimbing_id = $pembimbingId; // ini id guru dari users
        $siswa->save();

        return back()->with('success', 'Siswa berhasil ditambahkan ke pembimbing.');
    }

    // Hapus siswa dari pembimbing
    public function destroy($id, $siswa_id)
    {
        $siswa = User::where('role', 'siswa')
            ->where('id', $siswa_id)
            ->where('pembimbing_id', $id)
            ->firstOrFail();

        $siswa->pembimbing_id = null;
        $siswa->save();

        return back()->with('success', 'Siswa berhasil dihapus dari pembimbing.');
    }
}