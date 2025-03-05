<?php

namespace App\Http\Controllers;

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
            'iduka.user.pembimbingpkl' // Mengambil pembimbing lewat user di iduka
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

    public function downloadPdf()
    {
        $pdf = Pdf::loadView('persuratan.suratPengajuan.surat-pengajuan');
        return $pdf->download('surat_pengajuan_pkl.pdf');
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
