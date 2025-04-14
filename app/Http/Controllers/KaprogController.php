<?php

namespace App\Http\Controllers;

use App\Models\Cp;
use App\Models\Atp;
use App\Models\User;
use App\Models\Iduka;
use App\Models\UsulanIduka;
use Illuminate\Http\Request;
use App\Models\PengajuanUsulan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            ->where('konke_id', $kaprog->konke_id)
            ->get();


        $groupedIduka = $usulanIdukas->groupBy('email'); // setiap group mewakili satu usulan IDUKA

        $pengajuanUsulans = PengajuanUsulan::with(['user.dataPribadi.kelas', 'iduka'])
            ->where('status', 'proses')
            ->where('konke_id', $kaprog->konke_id)
            ->get()
            ->groupBy('iduka_id');



        return view('kaprog.review.reviewusulan', compact('usulanIdukas', 'pengajuanUsulans', 'groupedIduka'));
    }


    public function detailPengajuanSiswa($pengajuanId)
    {
        $usulan = PengajuanUsulan::with(['user.dataPribadi.kelas', 'user.dataPribadi.konkes', 'iduka'])->findOrFail($pengajuanId);
        return view('kaprog.review.detailpengajuansiswa', compact('usulan'));
    }

    public function show($id)
    {
        $usulan = UsulanIduka::with(['user.dataPribadi.konkes', 'user.dataPribadi.kelas'])
            ->findOrFail($id);

        return view('kaprog.review.detailusulan', compact('usulan'));
    }

    // public function showUsulan($id)
    // {
    //     $usulan = PengajuanUsulan::with(['user.dataPribadi.konkes', 'user.dataPribadi.kelas', 'iduka'])
    //         ->findOrFail($id);

    //     return view('kaprog.review.detailusulanpkl', compact('usulan'));
    // }

    public function diterima($id, Request $request)
    {
        $usulan = UsulanIduka::findOrFail($id);
    

        // Buat akun user untuk IDUKA terlebih dahulu
        $user = User::create([
            'name' => $usulan->nama,
            'nip' => $usulan->email,
            'password' => $usulan->password, // sudah di-hash dari awal
            'role' => 'iduka',
        ]);


        // Buat data di tabel idukas dan arahkan ke user_id dari akun IDUKA
        $iduka = Iduka::create([
            'user_id' => $user->id, // <- ini sekarang menunjuk ke user ID dari akun IDUKA
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
            'password' => $usulan->password,
            'kuota_pkl' => $usulan->kuota_pkl ?? 0,
        ]);



        // Tambahkan iduka_id ke user agar relasi lengkap (jika pakai relasi ke iduka)
        $user->update(['iduka_id' => $iduka->id]);

        // Update status usulan
        $usulan->update(['status' => 'diterima']);

        return redirect()->route('review.usulan')->with('success', 'Usulan IDUKA diterima dan akun pengguna berhasil dibuat.');
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

        return redirect()->route('kaprog.review.detailUsulanPkl', $usulan->iduka_id)

            ->with($type, $msg);

    }

    public function historyDiterima()
    {
        $kaprog = DB::table('gurus')->where('user_id', Auth::id())->first();
        if (!$kaprog) {
            return redirect()->back()->with('error', 'Data Kaprog tidak ditemukan.');
        }

        $usulanDiterima = UsulanIduka::with(['user.dataPribadi.kelas'])
            ->where('status', 'diterima')
            ->where('konke_id', $kaprog->konke_id)
            ->get();

        $usulanDiterimaPkl = PengajuanUsulan::with(['user.dataPribadi.kelas', 'iduka'])
            ->where('status', 'diterima')
            ->where('konke_id', $kaprog->konke_id)
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
            ->where('konke_id', $kaprog->konke_id)
            ->get();

        $usulanDitolakPkl = PengajuanUsulan::with(['user.dataPribadi.kelas', 'iduka'])
            ->where('status', 'ditolak')
            ->whereHas('user', function ($query) use ($kaprog) {
                $query->where('konke_id', $kaprog->konke_id);
            })
            ->get();

        return view('kaprog.review.historyditolak', compact('usulanDitolak', 'usulanDitolakPkl'));
    }


    // public function showDetailUsulan($id)
    // {
    //     $usulan = UsulanIduka::with('user.dataPribadi.kelas', 'user.dataPribadi.konkes')
    //                 ->findOrFail($id);

    //     return view('kaprog.review.detailusulan', compact('usulan'));
    // }




    public function showDetailPengajuanIduka($iduka_id)
    {
        $iduka = Iduka::findOrFail($iduka_id);
        $pengajuans = PengajuanUsulan::where('iduka_id', $iduka_id)
            ->where('status', 'proses') // hanya yang masih dalam proses
            ->with(['user.dataPribadi.kelas']) // eager load user, data pribadi, dan kelas
            ->get();


        return view('kaprog.review.detailpengajuaniduka', compact('iduka', 'pengajuans'));
    }

}
