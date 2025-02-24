<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PersuratanController extends Controller
{
    public function index() {
        return view('persuratan.percetakan.suratPengajuan');
    }

    public function show() {
        return view('persuratan.percetakan.detailSuratPengajuan');
    }

    public function downloadPdf()
{
    $pdf = Pdf::loadView('persuratan.percetakan.surat-pengajuan');
    return $pdf->download('surat_pengajuan_pkl.pdf');
}

    
}
