<?php

namespace App\Http\Controllers;

use App\Models\Cp;
use App\Models\Atp;
use App\Models\Iduka;
use App\Models\UsulanIduka;
use Illuminate\Http\Request;
use App\Models\PengajuanUsulan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    
        // Ambil usulan dari tabel UsulanIduka yang punya konke_id sama dengan Kaprog
        $usulanIdukas = UsulanIduka::with(['user.dataPribadi.kelas'])
            ->where('status', 'proses')
            ->where('konke_id', $kaprog->konke_id)
            ->get();
    
        // Ambil data dari PengajuanUsulan yang punya konke_id sama dengan Kaprog
        $pengajuanUsulans = PengajuanUsulan::with(['user.dataPribadi.kelas'])
            ->where('status', 'proses')
            ->where('konke_id', $kaprog->konke_id)
            ->get();
    
        return view('kaprog.review.reviewusulan', compact('usulanIdukas', 'pengajuanUsulans'));
    }
    


    public function showUsulan($id)
    {
        // Ambil data PengajuanUsulan dengan user, data pribadi, konsentrasi keahlian, kelas, dan iduka
        $usulan = PengajuanUsulan::with(['user.dataPribadi.konkes', 'user.dataPribadi.kelas', 'iduka'])
            ->where('id', $id)
            ->firstOrFail(); // Akan error jika tidak ditemukan
    
        return view('kaprog.review.detailusulanpkl', compact('usulan'));
    }

    public function show($id)
    {
        // Ambil data PengajuanUsulan dengan user, data pribadi, konsentrasi keahlian, kelas, dan iduka
        $usulan = UsulanIduka::with(['user.dataPribadi.konkes', 'user.dataPribadi.kelas'])
            ->where('id', $id)
            ->firstOrFail(); // Akan error jika tidak ditemukan
    
        return view('kaprog.review.detailusulan', data: compact('usulan'));
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

        return view('kaprog.review.reviewusulan')->with('success', 'Usulan diterima.');
    }

    public function diterimaUsulan(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:diterima,ditolak']);

        $usulan = PengajuanUsulan::findOrFail($id);
        $usulan->update(['status' => $request->status]);

        return view('kaprog.review.reviewusulan')->with('success', 'Usulan berhasil diperbarui.');
    }


    public function ditolak($id)
    {
        $usulan = UsulanIduka::findOrFail($id);
        $usulan->update(['status' => 'ditolak']);

        return view('kaprog.review.reviewusulan')->with('error', 'Usulan ditolak.');
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
            ->where('konke_id', $kaprog->konke_id) // Filter sesuai Kaprog yang login
            ->get();

            $usulanDiterimaPkl = PengajuanUsulan::with(['user.dataPribadi.kelas', 'iduka'])
            ->where('status', 'diterima')
            ->where('konke_id', $kaprog->konke_id) // Filter sesuai Kaprog yang login
            ->get();

        return view('kaprog.review.historyditerima', compact('usulanDiterima', 'usulanDiterimaPkl'));
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
            ->where('konke_id', $kaprog->konke_id) // Filter sesuai Kaprog yang login
            ->get();

        $usulanDitolakPkl = PengajuanUsulan::with(['user.dataPribadi.kelas', 'iduka'])
            ->where('status', 'ditolak')
            ->where('konke_id', $kaprog->konke_id) // Filter sesuai Kaprog yang login
            ->get();

        return view('kaprog.review.historyditolak', compact('usulanDitolak', 'usulanDitolakPkl'));
    }
}
