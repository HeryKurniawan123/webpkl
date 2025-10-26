<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PindahPklController extends Controller
{
    public function create()
    {
        return view('siswa.pindahpkl.pengajuanpindah');
    }

    public function store(Request $request)
    {
        return redirect()->back()->with('success', 'Pengajuan pindah berhasil dikirim!');
    }

    public function ajukan(Request $request)
    {
        $user = Auth::user();

        // ambil data pengajuan PKL milik siswa yang sudah diterima
        $pengajuan = DB::table('pengajuan_pkl')
            ->where('siswa_id', $user->id)
            ->where('status', 'diterima')
            ->first();

        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Kamu belum diterima di tempat PKL, belum bisa ajukan pindah.');
        }

        // cek apakah sudah pernah ajukan pindah dan masih diproses
        $cek = DB::table('pindah_pkl')
            ->where('siswa_id', $user->id)
            ->whereIn('status', ['menunggu', 'diterima'])
            ->first();

        if ($cek) {
            return redirect()->back()->with('info', 'Kamu sudah memiliki pengajuan pindah yang masih diproses.');
        }

        // simpan pengajuan pindah baru
        DB::table('pindah_pkl')->insert([
            'siswa_id' => $user->id,
            'iduka_id' => $pengajuan->iduka_id,
            'konke_id' => $user->konke_id,
            'status' => 'menunggu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan pindah berhasil dikirim ke Kaprog untuk diverifikasi.');
    }

    // list pengajuan pindah untuk kaprog
    public function indexKaprog()
    {
        $kaprog = Auth::user();

        $pindah = DB::table('pindah_pkl')
            ->join('users', 'pindah_pkl.siswa_id', '=', 'users.id')
            ->join('idukas', 'pindah_pkl.iduka_id', '=', 'idukas.id')
            ->select(
                'pindah_pkl.id',
                'pindah_pkl.status',
                'pindah_pkl.created_at',
                'pindah_pkl.updated_at',
                'users.name as nama_siswa',
                'users.kelas_id',
                'idukas.nama as nama_iduka'
            )
            ->where('pindah_pkl.status', 'menunggu')
            ->where('pindah_pkl.konke_id', $kaprog->konke_id)
            ->get();

        return view('kaprog.pindahpkl.index', compact('pindah'));
    }

    // verifikasi pengajuan pindah
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        DB::table('pindah_pkl')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan pindah berhasil diverifikasi.');
    }

    public function riwayat()
    {
        $user = Auth::user();

        $pengajuanPindah = DB::table('pindah_pkl')
            ->join('idukas', 'pindah_pkl.iduka_id', '=', 'idukas.id')
            ->select('pindah_pkl.*', 'idukas.nama as nama_iduka')
            ->where('pindah_pkl.siswa_id', $user->id)
            ->orderBy('pindah_pkl.created_at', 'desc')
            ->get();

        return view('siswa.dashboard', compact('pengajuanPindah'));
    }

    // Tambahkan method untuk download surat
    public function downloadSurat($id)
    {
        $pindahPkl = DB::table('pindah_pkl')
            ->join('users', 'pindah_pkl.siswa_id', '=', 'users.id')
            ->join('idukas', 'pindah_pkl.iduka_id', '=', 'idukas.id')
            ->select('pindah_pkl.*', 'users.name as nama_siswa', 'idukas.nama as nama_iduka')
            ->where('pindah_pkl.id', $id)
            ->first();

        if (!$pindahPkl || $pindahPkl->status != 'diterima') {
            return redirect()->back()->with('error', 'Surat tidak tersedia atau pengajuan belum diterima.');
        }

        // Logika untuk generate PDF surat pengunduran diri
        // Untuk sementara kita return response sederhana
        return response()->streamDownload(function () use ($pindahPkl) {
            echo "SURAT PENGUNDURAN DIRI\n";
            echo "========================\n\n";
            echo "Yang bertanda tangan di bawah ini:\n";
            echo "Nama: " . $pindahPkl->nama_siswa . "\n";
            echo "Tempat PKL: " . $pindahPkl->nama_iduka . "\n";
            echo "\nDengan ini mengundurkan diri dari tempat PKL tersebut.\n";
            echo "\nTerima kasih.\n";
        }, 'Surat_Pengunduran_Diri_' . $pindahPkl->nama_siswa . '.txt');
    }
}