<?php
//anjay
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


        return redirect()->route('siswa.dashboard')->with('success', 'Pengajuan PKL berhasil diajukan.');
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
        $iduka = Iduka::findOrFail($iduka_id);
        $sisa_kuota = $iduka->kuota_pkl - PengajuanPkl::where('iduka_id', $iduka_id)
            ->where('status', 'diterima')
            ->count();


        // Ambil hanya pengajuan yang statusnya "proses"
        $pengajuans = PengajuanPkl::with(['dataPribadi.user', 'dataPribadi.kelas'])
            ->where('iduka_id', $iduka_id)
            ->where('status', 'proses')
            ->get();


        return view('pengajuan.review', compact('pengajuans', 'iduka', 'sisa_kuota', 'iduka_id'));
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

    // Pastikan hanya memproses jika belum diterima sebelumnya
    if ($pengajuan->status !== 'diterima') {
        $iduka = Iduka::findOrFail($pengajuan->iduka_id);

        // Cek apakah kuota tersedia
        if ($iduka->kuota_pkl > 0) {
            $iduka->decrement('kuota_pkl');
            $pengajuan->update(['status' => 'diterima']);

            return redirect()->route('pengajuan.review')->with('success', 'Pengajuan PKL telah diterima dan kuota dikurangi.');
        } else {
            // Jika kuota kosong, arahkan ke halaman iduka pribadi dengan alert error
            return redirect()->route('iduka.pribadi')->with('error', 'IDUKA belum mengisi kuota PKL.');
        }
    }

    return redirect()->route('pengajuan.review')->with('info', 'Pengajuan sudah diterima sebelumnya.');
}

public function tolak($id)
{
    $pengajuan = PengajuanPkl::findOrFail($id);
    $pengajuan->update(['status' => 'ditolak']);

    return redirect()->route('pengajuan.review')->with('error', 'Pengajuan PKL telah ditolak.');
}

}
