<?php

namespace App\Http\Controllers;

use App\Models\Cp;
use App\Models\Atp;
use App\Models\Iduka;
use App\Models\UsulanIduka;
use App\Models\PengajuanUsulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KaprogController extends Controller
{
    public function reviewUsulan()
    {
        $user = Auth::user();

        $kaprog = DB::table('gurus')->where('user_id', $user->id)->first();
        if (!$kaprog) {
            return redirect()->back()->with('error', 'Data Kaprog tidak ditemukan.');
        }

        $usulanIdukas = UsulanIduka::with(['user.dataPribadi.kelas'])
            ->where('status', 'proses')
            ->where('konke_id', $kaprog->konkes_id)
            ->get();

        $pengajuanUsulans = PengajuanUsulan::with(['user.dataPribadi.kelas'])
            ->where('status', 'proses')
            ->where('konke_id', $kaprog->konkes_id)
            ->get();

        return view('kaprog.review.reviewusulan', compact('usulanIdukas', 'pengajuanUsulans'));
    }

    public function show($id)
    {
        $usulan = UsulanIduka::with(['user.dataPribadi.konkes', 'user.dataPribadi.kelas'])
            ->findOrFail($id);

        return view('kaprog.review.detailusulan', compact('usulan'));
    }

    public function showUsulan($id)
    {
        $usulan = PengajuanUsulan::with(['user.dataPribadi.konkes', 'user.dataPribadi.kelas', 'iduka'])
            ->findOrFail($id);

        return view('kaprog.review.detailusulanpkl', compact('usulan'));
    }

    public function diterima($id)
    {
        $usulan = UsulanIduka::findOrFail($id);

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
            'password' => bcrypt('defaultpassword'),
            'kuota_pkl' => $usulan->kuota_pkl ?? 0,
        ]);

        $usulan->update(['status' => 'diterima']);

        return redirect()->route('review.usulan')->with('success', 'Usulan IDUKA diterima.');
    }

    public function ditolak($id)
    {
        $usulan = UsulanIduka::findOrFail($id);
        $usulan->update(['status' => 'ditolak']);

        return redirect()->route('review.usulan')->with('error', 'Usulan IDUKA ditolak.');
    }

    public function diterimaUsulan(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:diterima,ditolak']);

        $usulan = PengajuanUsulan::findOrFail($id);
        $usulan->update(['status' => $request->status]);

        $msg = $request->status === 'diterima' ? 'Pengajuan PKL diterima.' : 'Pengajuan PKL ditolak.';
        $type = $request->status === 'diterima' ? 'success' : 'error';

        return redirect()->route('review.usulan')->with($type, $msg);
    }

    public function historyDiterima()
    {
        $kaprog = DB::table('gurus')->where('user_id', Auth::id())->first();
        if (!$kaprog) {
            return redirect()->back()->with('error', 'Data Kaprog tidak ditemukan.');
        }

        $usulanDiterima = UsulanIduka::with(['user.dataPribadi.kelas'])
            ->where('status', 'diterima')
            ->where('konke_id', $kaprog->konkes_id)
            ->get();

        $usulanDiterimaPkl = PengajuanUsulan::with(['user.dataPribadi.kelas', 'iduka'])
            ->where('status', 'diterima')
            ->where('konke_id', $kaprog->konkes_id)
            ->get();

        return view('kaprog.review.historyditerima', compact('usulanDiterima', 'usulanDiterimaPkl'));
    }

    public function historyDitolak()
    {
        $kaprog = DB::table('gurus')->where('user_id', Auth::id())->first();
        if (!$kaprog) {
            return redirect()->back()->with('error', 'Data Kaprog tidak ditemukan.');
        }

        $usulanDitolak = UsulanIduka::with(['user.dataPribadi.kelas'])
            ->where('status', 'ditolak')
            ->where('konke_id', $kaprog->konkes_id)
            ->get();

        $usulanDitolakPkl = PengajuanUsulan::with(['user.dataPribadi.kelas', 'iduka'])
            ->where('status', 'ditolak')
            ->where('konke_id', $kaprog->konkes_id)
            ->get();

        return view('kaprog.review.historyditolak', compact('usulanDitolak', 'usulanDitolakPkl'));
    }
}
