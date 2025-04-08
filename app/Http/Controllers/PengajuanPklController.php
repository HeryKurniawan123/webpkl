<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use App\Models\PengajuanPkl;
use Illuminate\Http\Request;

class PengajuanPklController extends Controller
{
    // Siswa mengajukan PKL
    public function ajukan(Request $request, $iduka_id)
    {
        $siswa = auth()->user();
    
        // Cek apakah siswa sudah pernah diterima di IDUKA manapun
        if (PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'diterima')->exists()) {
            return back()->with('error', 'Anda sudah diterima PKL di IDUKA, tidak dapat mengajukan ulang.');
        }
    
        // Cek apakah siswa sudah mengajukan ke IDUKA ini sebelumnya
        if (PengajuanPkl::where('siswa_id', $siswa->id)->where('iduka_id', $iduka_id)->exists()) {
            return back()->with('error', 'Anda sudah mengajukan PKL ke IDUKA ini.');
        }
    
        // Simpan pengajuan baru
        PengajuanPkl::create([
            'siswa_id' => $siswa->id,
            'iduka_id' => $iduka_id,
            'status' => 'proses',
        ]);
    
        return back()->with('success', 'Pengajuan PKL berhasil diajukan.');
    }
    

    // IDUKA menerima atau menolak pengajuan
    public function verifikasi(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:diterima,ditolak']);

        $pengajuan = PengajuanPkl::findOrFail($id);
        $pengajuan->update(['status' => $request->status]);

        return back()->with('success', 'Pengajuan berhasil diperbarui.');
    }

    // Persuratan melihat semua pengajuan
    public function index()
    {
        $pengajuan = PengajuanPkl::with(['siswa', 'iduka'])->get();
        return view('pengajuan.index', compact('pengajuan'));
    }

    // Download Capaian Pembelajaran (CP)
    public function downloadCp($iduka_id)
    {
        $iduka = Iduka::with('cp')->findOrFail($iduka_id);

        // Asumsikan CP berupa file dalam database
        if ($iduka->cp && file_exists(storage_path('app/' . $iduka->cp->file))) {
            return response()->download(storage_path('app/' . $iduka->cp->file));
        }

        return back()->with('error', 'File CP tidak ditemukan.');
    }

    public function reviewPengajuan()
    {
        $iduka_id = auth()->user()->iduka_id;
    
        // Ambil hanya pengajuan yang statusnya "proses"
        $pengajuans = PengajuanPkl::with(['dataPribadi.user', 'dataPribadi.kelas'])
            ->where('iduka_id', $iduka_id)
            ->where('status', 'proses')
            ->get();
            
    
        return view('pengajuan.review', compact('pengajuans'));
    }
    






    public function showPengajuan($id)
    {
        $pengajuan = PengajuanPkl::with(['dataPribadi.kelas', 'iduka'])->findOrFail($id);
        return view('pengajuan.detail', compact('pengajuan'));
    }


    public function reviewPengajuanDiterima()
{
    $iduka_id = auth()->user()->iduka_id;

    $pengajuans = PengajuanPkl::with(['dataPribadi.user', 'dataPribadi.kelas'])
        ->where('iduka_id', $iduka_id)
        ->where('status', 'diterima') // Hanya ambil yang diterima
        ->get();

    return view('pengajuan.historyditerima', compact('pengajuans'));
}

public function reviewPengajuanDitolak()
{
    $iduka_id = auth()->user()->iduka_id;

    $pengajuans = PengajuanPkl::with(['dataPribadi.user', 'dataPribadi.kelas'])
        ->where('iduka_id', $iduka_id)
        ->where('status', 'ditolak') // Hanya ambil yang ditolak
        ->get();

    return view('pengajuan.historyditolak', compact('pengajuans'));
}

    public function terima($id)
{
    $pengajuan = PengajuanPkl::findOrFail($id);
    $pengajuan->update(['status' => 'diterima']);

    return redirect()->route('review.pengajuan')->with('success', 'Pengajuan PKL telah diterima.');
}

public function tolak($id)
{
    $pengajuan = PengajuanPkl::findOrFail($id);
    $pengajuan->update(['status' => 'ditolak']);

    return redirect()->route('review.pengajuan')->with('error', 'Pengajuan PKL telah ditolak.');
}

}
