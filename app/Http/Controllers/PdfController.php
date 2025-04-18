<?php

namespace App\Http\Controllers;

use App\Models\DataPribadi;
use App\Models\UsulanIduka;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function usulanPdf()
    {
        $user = Auth::user();
        $dataPribadi = DataPribadi::where('user_id', $user->id)->first();
        $usulanIduka = UsulanIduka::where('user_id', $user->id)->latest()->first();


        $kaprog = DB::table('usulan_idukas')
            ->where('konke_id', $usulanIduka->konke_id)
            ->first();

        $pdf = Pdf::loadView('data.usulan.suratUsulanPDF', compact('dataPribadi', 'usulanIduka', 'kaprog'));
        return $pdf->download('surat_usulan_iduka_baru.pdf');
    }
    public function siswaUsulanPdf()
    {
        $user = Auth::user();
        
        // Ambil data siswa yang sedang login
        $dataPribadi = DataPribadi::with(['kelas', 'konkes'])->where('user_id', $user->id)->first();
        
        // Ambil data usulan IDUKA terbaru berdasarkan user
        $usulanIduka = UsulanIduka::where('user_id', $user->id)->latest()->first();
    
        // Validasi jika data tidak ditemukan
        if (!$dataPribadi || !$usulanIduka) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    
        // Generate PDF menggunakan template suratUsulanSiswaPDF.blade.php
        $pdf = Pdf::loadView('data.usulan.siswaUsulanPdf', compact('dataPribadi', 'usulanIduka'));
        
        return $pdf->download('siswa_usulan_iduka.pdf');
    }

    public function suratPengantarPDF(){
         $data = [
            'nama' => 'Vayana Liora',
            'tanggal' => now()->format('d-m-Y'),
        ];

        $pdf = Pdf::loadView('surat_pengantar.surat_pengantarPDF', $data);

        return $pdf->download('surat-pengantar.pdf');

    }
}
