<?php

namespace App\Http\Controllers;

use App\Models\CetakUsulan;
use App\Models\IdukaAtp;
use App\Models\PengajuanPkl;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PersuratanController extends Controller
{
    public function index()
    {
        return view('persuratan.suratPengajuan.suratPengajuan');
    }
// DETAIL SISWA DI PERSURATAN
    public function show($id)
    {
        $pengajuan = CetakUsulan::with([
            'dataPribadi.kelas',
            'iduka.user.pembimbingpkl', // Mengambil pembimbing lewat user di iduka
            'iduka.konkes',
            'iduka.cp',
            'iduka.atps'
        ])->findOrFail($id);

        return view('persuratan.suratPengajuan.detailSuratPengajuan', compact('pengajuan'));
    }



    public function idukaBaru()
    {
        return view('persuratan.PengajuanIdukaBaru.idukaBaru');
    }

    public function showidukaBaru()
    {
        return view('persuratan.PengajuanIdukaBaru.detailidukaBaru');
    }

    public function downloadPdf($id)
    {
        $pengajuan = CetakUsulan::with(['dataPribadi.kelas', 'iduka.user.pembimbingpkl', 'iduka.konkes', 'iduka.cp', 'iduka.atps'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('persuratan.suratPengajuan.surat-pengajuan', compact('pengajuan'));

        return $pdf->download('Surat_Pengajuan_' . $pengajuan->dataPribadi->nama . '.pdf');
    }

    public function create()
    {
        return view('persuratan.data_pribadi.form');
    }

    public function reviewPengajuan()
    {
        $pengajuanUsulans = CetakUsulan::with(['dataPribadi.kelas', 'iduka'])
            ->where('status', 'proses')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('iduka_id');

        return view('persuratan.review', compact('pengajuanUsulans'));
    }


    public function detailUsulan($iduka_id)
    {
        $pengajuanUsulans = CetakUsulan::with(['dataPribadi.kelas', 'iduka'])
            ->where('iduka_id', $iduka_id)
            ->where('status', 'proses')
            ->get();
    
        return view('persuratan.detail', compact('pengajuanUsulans', 'iduka_id'));
    }
    


    public function prosesPengajuan($id)
    {
        $pengajuan = CetakUsulan::findOrFail($id);
        $pengajuan->status = 'sudah';
        $pengajuan->save();

        return response()->json(['success' => true, 'message' => 'Data berhasil di kirim ke Kaprog.']);
    }

    //mengubah semua status siswa jadi sudah
    public function kirimSemua($iduka_id)
    {
        $pengajuanList = CetakUsulan::where('iduka_id', $iduka_id)->where('status', 'proses')->get();

        foreach ($pengajuanList as $pengajuan) {
            $pengajuan->status = 'sudah';
            $pengajuan->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil di kirim ke Kaprog.'
        ]);
    }

    public function suratPengantar()
    {
        return view('surat_pengantar.surat_pengantarPDF');
    }

    public function historykirim()
    {
        $dataDikirim = CetakUsulan::with('iduka', 'siswa')
            ->where('status', 'sudah')
            ->orderByDesc('created_at') // Urut berdasarkan tanggal terbaru
            ->get();
    
        return view('persuratan.historykirim', compact('dataDikirim'));
    }
    

    public function downloadKelompokPdf($iduka_id)
{
    // Ambil semua pengajuan berdasarkan IDUKA
    $pengajuans = CetakUsulan::with(['dataPribadi.kelas', 'iduka.konkes'])
        ->where('iduka_id', $iduka_id)
        ->where('status', 'proses')
        ->get();

    if ($pengajuans->isEmpty()) {
        return back()->with('error', 'Tidak ada data pengajuan untuk IDUKA ini.');
    }

    $iduka = $pengajuans->first()->iduka;

    $pdf = Pdf::loadView('persuratan.suratPengajuan.surat-pengajuan-kelompok', compact('pengajuans', 'iduka'));

    return $pdf->download('Surat_Pengajuan_Kelompok_' . $iduka->nama . '.pdf');
}
}
