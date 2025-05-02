<?php

namespace App\Http\Controllers;

use App\Models\CetakUsulan;
use App\Models\DataPribadi;
use App\Models\Iduka;
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

        // Mencari data dari usulan_idukas
        $usulanIduka = UsulanIduka::where('user_id', $user->id)->latest()->first();

        // Jika tidak ditemukan di usulan_idukas, cari di pengajuan_usulans
        if (!$usulanIduka) {
            $pengajuan = DB::table('pengajuan_usulans')->where('user_id', $user->id)->latest()->first();

            if ($pengajuan && $pengajuan->iduka_id) {
                $usulanIduka = DB::table('idukas')->where('id', $pengajuan->iduka_id)->first();
            }
        } else {
            // Jika ditemukan di usulan_idukas, ambil iduka_id dari situ
            $usulanIduka = DB::table('idukas')->where('id', $usulanIduka->iduka_id)->first();
        }

        // Jika usulanIduka masih kosong, tampilkan error
        if (!$usulanIduka) {
            return back()->with('error', 'Data IDUKA tidak ditemukan.');
        }

        // Mencari kaprog berdasarkan konke_id
        // Gunakan model User agar bisa akses relasi 'konke'
        $kaprog = \App\Models\User::with('konke')
            ->where('role', 'kaprog')
            ->where('konke_id', $dataPribadi->konke_id)
            ->first();


        // Jika Kaprog tidak ditemukan, tampilkan error
        if (!$kaprog) {
            return back()->with('error', 'Kaprog tidak ditemukan.');
        }
        // Mapping singkatan jurusan
        $singkatan = [
            'Pengembangan Perangkat Lunak dan Gim' => 'PPLG',
            'Manajemen  Perkantoran dan  Layanan Bisnis' => 'MPLB',
            'Desain Pemodelan  dan Informasi  Bangunan' => 'DPIB',
            'Akuntansi dan  Keuangan  Lembaga' => 'AKL',
            'Teknik Jaringan Komputer dan Telekomunikasi' => 'TJKT',
            'Teknik Otomotif' => 'TO',
            'Seni Pertunjukan' => 'SP',
        ];
        $namaJurusan = strtoupper($kaprog->konke->name_konke ?? 'Tidak diketahui');
        $singkatanJurusan = $singkatan[$namaJurusan] ?? $namaJurusan;


        // Generate PDF
        $pdf = Pdf::loadView('data.usulan.suratUsulanPDF', compact('dataPribadi', 'usulanIduka', 'kaprog', 'singkatanJurusan'));
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

    public function unduhDetailIdukaPDF($id)
    {
        $dataIduka = Iduka::findOrFail($id);
        $pdf = Pdf::loadView('iduka.dataiduka.detailDataIdukaPDF', compact('dataIduka'));
        return $pdf->download('data-iduka-' . $dataIduka->nama . '.pdf');
    }
}
