<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AbsensiPkl;
use Carbon\Carbon;

class AbsensiSiswaController extends Controller
{

    public function index()
    {
        return view('siswa.absensi.index');
    }

    public function absenMasuk(Request $request)
    {
        $user = Auth::user();

        AbsensiPkl::create([
            'nis' => $user->nip, // relasi ke users
            'status' => 'Hadir',
            'waktu' => now(),
            'tipe_izin' => null,
        ]);

        return back()->with('success', 'Absen masuk berhasil.');
    }

    public function absenPulang(Request $request)
    {
        $user = Auth::user();

        AbsensiPkl::create([
            'nis' => $user->nip,
            'status' => 'Pulang',
            'waktu' => now(),
        ]);

        return back()->with('success', 'Absen pulang berhasil.');
    }

    public function izin(Request $request)
    {
        $request->validate([
        'tipe_izin'   => 'required|in:Sakit,Izin',
        'tanggal'     => 'required|date',
        'alasan'      => 'required|string|max:255',
    ]);

    $siswa = Auth::user()->siswa;

    AbsensiPkl::create([
        'user_id'    => Auth::id(),
        'nis'        => $siswa ? $siswa->nis : null,
        'status'     => 'Izin',
        'tipe_izin'  => $request->tipe_izin,
        'waktu'      => $request->tanggal,
        'keterangan' => $request->alasan,
    ]);

    return back()->with('success', 'Izin berhasil dicatat!');
    }


}
