<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use App\Models\UsulanIduka;
use App\Models\Cp;
use App\Models\Atp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KaprogController extends Controller
{
    public function reviewUsulan()
{
    $user = Auth::user();
    
    // Ambil data Kaprog dari tabel 'gurus' berdasarkan user_id
    $kaprog = DB::table('gurus')->where('user_id', $user->id)->first();

    if (!$kaprog) {
        return redirect()->back()->with('error', 'Data Kaprog tidak ditemukan.');
    }

    // Ambil usulan yang punya konke_id sama dengan Kaprog
    $usulanIdukas = UsulanIduka::with(['user.dataPribadi.kelas'])
        ->where('status', 'proses')
        ->where('konke_id', $kaprog->konkes_id) // Sesuaikan dengan Kaprog yang login
        ->get();

    return view('kaprog.review.reviewusulan', compact('usulanIdukas'));
}


public function show($id)
{
    $usulan = UsulanIduka::with(['user.dataPribadi.konkes', 'user.dataPribadi.kelas'])
        ->where('id', $id)
        ->firstOrFail(); // Gunakan firstOrFail() agar error jika tidak ditemukan

    return view('kaprog.review.detailusulan', compact('usulan'));
}




    public function diterima($id)
    {
        $usulan = UsulanIduka::findOrFail($id);

        // Tambahkan ke tabel idukas (anggap model Iduka sudah ada)
        Iduka::create([
            'nama' => $usulan->nama,
            'nama_pimpinan' => $usulan->nama_pimpinan,
            'nip_pimpinan' => $usulan->nip_pimpinan,
            'jabatan' => $usulan->jabatan,
            'alamat' => $usulan->alamat,
            'kode_pos' => $usulan->kode_pos,
            'telepon' => $usulan->telepon,
            'email' => $usulan->email,
            'bidang_industri' => $usulan->bidang_industri,
            'kerjasama' => $usulan->kerjasama,
            'password' => bcrypt('defaultpassword'), // Tambahkan ini
            'kuota_pkl' => $usulan->kuota_pkl ?? 0, // Tambahkan ini
        ]);

        // Ubah status usulan
        $usulan->update(['status' => 'diterima']);

        return redirect()->back()->with('success', 'Usulan diterima.');
    }

    public function ditolak($id)
    {
        $usulan = UsulanIduka::findOrFail($id);
        $usulan->update(['status' => 'ditolak']);

        return redirect()->back()->with('error', 'Usulan ditolak.');
    }

    public function historyDiterima()
    {
        $user = Auth::user();
        $kaprog = DB::table('gurus')->where('user_id', $user->id)->first();

        if (!$kaprog) {
            return redirect()->back()->with('error', 'Data Kaprog tidak ditemukan.');
        }

        $usulanDiterima = UsulanIduka::with(['user.dataPribadi.kelas'])
            ->where('status', 'diterima')
            ->where('konke_id', $kaprog->konkes_id) // Filter sesuai Kaprog yang login
            ->get();

        return view('kaprog.review.historyditerima', compact('usulanDiterima'));
    }

    public function historyDitolak()
    {
        $user = Auth::user();
        $kaprog = DB::table('gurus')->where('user_id', $user->id)->first();

        if (!$kaprog) {
            return redirect()->back()->with('error', 'Data Kaprog tidak ditemukan.');
        }

        $usulanDitolak = UsulanIduka::with(['user.dataPribadi.kelas'])
            ->where('status', 'ditolak')
            ->where('konke_id', $kaprog->konkes_id) // Filter sesuai Kaprog yang login
            ->get();

        return view('kaprog.review.historyditolak', compact('usulanDitolak'));
    }

    


   

}
