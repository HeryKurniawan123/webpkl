<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class PdfController extends Controller
{
    public function usulanPdf () {
        $pdf = Pdf::loadView('data.usulan.suratUsulanPDF');
        return $pdf->download('surat_usulan_iduka_baru.pdf');       
    }
    public function siswaUsulanPdf () {
        $pdf = Pdf::loadView('data.usulan.siswaUsulanPDF');
        return $pdf->download('data_usulan_siswa.pdf');       
    }
}
