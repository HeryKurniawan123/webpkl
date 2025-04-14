<?php

namespace App\Http\Controllers;

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

    public function show($id)
    {
        $pengajuan = PengajuanPkl::with([
            'dataPribadi.kelas',
            'iduka.user.pembimbingpkl', // Mengambil pembimbing lewat user di iduka
            'iduka.konkes',
            'iduka.cps',
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
    $pengajuan = PengajuanPkl::with(['dataPribadi.kelas', 'iduka.user.pembimbingpkl', 'iduka.konkes', 'iduka.cps', 'iduka.atps'])
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
        // Ambil semua pengajuan tanpa filter status
        $pengajuans = PengajuanPkl::with(['dataPribadi', 'dataPribadi.kelas', 'iduka'])
            ->orderBy('created_at', 'desc')
            ->get();


        return view('persuratan.review', compact('pengajuans'));
    }
}
