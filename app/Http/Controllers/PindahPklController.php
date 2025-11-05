<?php

namespace App\Http\Controllers;

use App\Models\PindahPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
            ->whereIn('status', ['menunggu','menunggu_surat','diterima_iduka','siap_kirim','menunggu_konfirmasi_iduka'])
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

    public function downloadSurat($id)
    {
        // Ambil data pindah PKL beserta relasi yang dibutuhkan
        $pindah = PindahPkl::with(['siswa.kelas.konke', 'idukaLama', 'idukaBaru'])->findOrFail($id);

        // Tentukan IDUKA tujuan (iduka baru)
        $iduka = $pindah->idukaBaru ?? $pindah->idukaLama;

        // Tanggal surat
        $tanggal = Carbon::now()->translatedFormat('d F Y');

        // Generate PDF
        $pdf = Pdf::loadView('siswa.pindahpkl.surat', [
            'pindah' => [$pindah->siswa],
            'iduka' => $iduka,
            'tanggal' => $tanggal,
        ])->setPaper('a4', 'portrait');

        // Download PDF
        return $pdf->download('Surat_Pindah_PKL_' . str_replace(' ', '_', $pindah->siswa->name) . '.pdf');
    }
    
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
                'status' => 'ditolak_iduka',
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Pengajuan pindah telah ditolak oleh IDUKA.');
        }

        if ($request->status === 'diterima_iduka') {
            // Update status pindah PKL
            DB::table('pindah_pkl')->where('id', $id)->update([
                'status' => 'diterima_iduka',
                'updated_at' => now(),
            ]);

            /* Update history PKL dengan IDUKA baru
            /**  DB::table('history_pkl')
                ->where('user_id', $pindah->siswa_id)
                ->whereNull('iduka_baru_id')
                ->update([
                    'iduka_baru_id' => $pindah->iduka_id,
                    'updated_at' => now(),
                ]); */

            // Kosongkan iduka_id di tabel users untuk siswa tersebut
            DB::table('users')
                ->where('id', $pindah->siswa_id)
                ->update([
                    'iduka_id' => null,
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