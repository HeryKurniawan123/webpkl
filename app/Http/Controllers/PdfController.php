<?php

namespace App\Http\Controllers;

use App\Models\DataPribadi;
use App\Models\UsulanIduka;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function usulanPdf () {
       // Ambil data siswa yang sedang login
    $user = Auth::user();
    $dataPribadi = DataPribadi::where('user_id', $user->id)->first();
    $usulanIduka = UsulanIduka::where('user_id', $user->id)->latest()->first();

    // Pastikan data dikirim ke view
    $pdf = Pdf::loadView('data.usulan.suratUsulanPDF', compact('dataPribadi', 'usulanIduka'));
    return $pdf->download('surat_usulan_iduka_baru.pdf');   
    }
    public function siswaUsulanPdf () {
        $pdf = Pdf::loadView('data.usulan.siswaUsulanPDF');
        return $pdf->download('data_usulan_siswa.pdf');       
    }
}
