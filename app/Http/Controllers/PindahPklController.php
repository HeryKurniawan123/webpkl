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
            ->whereIn('status', ['menunggu', 'diterima', 'menunggu_surat', 'siap_kirim'])
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

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $pindah = DB::table('pindah_pkl')->where('id', $id)->first();

        if (!$pindah) {
            return redirect()->back()->with('error', 'Data pengajuan tidak ditemukan.');
        }

        if ($request->status === 'ditolak') {
            DB::table('pindah_pkl')->where('id', $id)->update([
                'status' => 'ditolak', // status ditolak kaprog
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Pengajuan pindah telah ditolak.');
        }

        if ($request->status === 'diterima') {
            DB::table('pindah_pkl')->where('id', $id)->update([
                'status' => 'menunggu_surat', // status menunggu persuratan
                'updated_at' => now(),
            ]);

            DB::table('history_pkl')->insert([
                'user_id' => $pindah->siswa_id,
                'iduka_lama_id' => $pindah->iduka_id,
                'iduka_baru_id' => null,
                'tgl_pindah' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

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

        if (!$pindahPkl || !in_array($pindahPkl->status, ['diterima_iduka', 'siap_kirim'])) {
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

    /**
     * ✅ FIXED: Hapus dd($pindah) yang menyebabkan error
     * Method untuk menampilkan pengajuan pindah PKL untuk IDUKA
     */
    public function indexIduka()
    {
        $iduka = auth()->user()->iduka;

        if (!$iduka) {
            return back()->with('error', 'Data IDUKA tidak ditemukan.');
        }

        $pindah = DB::table('pindah_pkl')
            ->join('users', 'pindah_pkl.siswa_id', '=', 'users.id')
            ->join('idukas', 'pindah_pkl.iduka_id', '=', 'idukas.id')
            ->select(
                'pindah_pkl.id',
                'pindah_pkl.status',
                'pindah_pkl.created_at',
                'users.name as nama_siswa',
                'users.kelas_id',
                'idukas.nama as nama_iduka'
            )
            ->where('pindah_pkl.iduka_id', $iduka->id)
            ->whereIn('pindah_pkl.status', ['siap_kirim', 'menunggu_konfirmasi_iduka'])
            ->orderByDesc('pindah_pkl.created_at')
            ->get();

        return view('iduka.pindahpkl.index', compact('pindah'));
    }


    /**
     * Konfirmasi pengajuan pindah PKL oleh IDUKA
     */
    public function konfirmasiIduka(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima_iduka,ditolak_iduka',
        ]);

        $pindah = DB::table('pindah_pkl')->where('id', $id)->first();

        if (!$pindah) {
            return redirect()->back()->with('error', 'Data pengajuan tidak ditemukan.');
        }

        if ($request->status === 'ditolak_iduka') {
            DB::table('pindah_pkl')->where('id', $id)->update([
                'status' => 'ditolak_iduka', // Status ditolak IDUKA
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Pengajuan pindah telah ditolak oleh IDUKA.');
        }

        if ($request->status === 'diterima_iduka') {
            // Update status pindah PKL
            DB::table('pindah_pkl')->where('id', $id)->update([
                'status' => 'diterima_iduka', // Status diterima IDUKA
                'updated_at' => now(),
            ]);

            // Update history PKL dengan IDUKA baru
            DB::table('history_pkl')
                ->where('user_id', $pindah->siswa_id)
                ->whereNull('iduka_baru_id')
                ->update([
                    'iduka_baru_id' => $pindah->iduka_id, // IDUKA baru
                    'updated_at' => now(),
                ]);
        }

        return redirect()->back()->with('success', 'Pengajuan pindah berhasil dikonfirmasi oleh IDUKA.');
    }

    /**
     * Menampilkan riwayat pengajuan pindah PKL untuk IDUKA
     */
    public function riwayatIduka()
    {
        $user = Auth::user();

        // Ambil data IDUKA yang sedang login
        $iduka = DB::table('idukas')->where('user_id', $user->id)->first();

        if (!$iduka) {
            return redirect()->back()->with('error', 'Data IDUKA tidak ditemukan.');
        }

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
            ->where('pindah_pkl.iduka_id', $iduka->id) // Hanya menampilkan untuk IDUKA yang login
            ->whereIn('pindah_pkl.status', ['diterima_iduka', 'ditolak_iduka'])
            ->orderBy('pindah_pkl.updated_at', 'desc')
            ->get();

        return view('iduka.pindahpkl.riwayat', compact('pindah'));
    }
}
