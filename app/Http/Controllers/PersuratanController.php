<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PersuratanController extends Controller
{
    public function index() {
        return view('persuratan.suratPengajuan.suratPengajuan');
    }

    public function show() {
        return view('persuratan.suratPengajuan.detailSuratPengajuan');
    }

    public function idukaBaru() {
        return view('persuratan.PengajuanIdukaBaru.idukaBaru');
    }

    public function showidukaBaru() {
        return view('persuratan.PengajuanIdukaBaru.detailidukaBaru');
    }

    public function downloadPdf()
    {
        $pdf = Pdf::loadView('persuratan.suratPengajuan.surat-pengajuan');
        return $pdf->download('surat_pengajuan_pkl.pdf');
    }

    public function create() {
        return view('persuratan.data_pribadi.form');
    }

    
}
