<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Ganti 'Facades\Pdf' jadi 'Facade\Pdf'

class SertifikatController extends Controller
{
    public function cetak()
    {
        $data = [
            'nama'             => 'Ade fikri',
            'konsentrasi'      => 'Teknik Kendaraan Ringan',
            'lama'             => '5 bulan',
            'tanggal_mulai'    => '13 Oktober 2025',
            'tanggal_selesai'  => '14 Februari 2026',
            'predikat'         => '',
            'kepala_sekolah'   => 'Fajriadi, S.Pd., M.Pd',
        ];

        return view('penilaian.sertifikat.index', $data);
    }

    public function cetakPdf($id)
    {
        $user      = User::findOrFail($id);
        $penilaian = Penilaian::where('users_id', $user->id)->get();

        $nilaiGuru  = $penilaian->where('jenis_penilaian', 'guru_pembimbing')->avg('nilai') ?? 0;
        $nilaiIduka = $penilaian->where('jenis_penilaian', 'instruktur_iduka')->avg('nilai') ?? 0;
        $nilaiAkhir = ($nilaiGuru + $nilaiIduka) / 2;

        $predikat = match(true) {
            $nilaiAkhir >= 86 => 'Sangat Baik',
            $nilaiAkhir >= 71 => 'Baik',
            $nilaiAkhir >= 56 => 'Cukup',
            default           => 'Kurang',
        };

        $data = [
            'nama'            => $user->name,
            'konsentrasi'     => 'Teknik Kendaraan Ringan',
            'lama'            => '5 bulan',
            'tanggal_mulai'   => '13 Oktober 2025',
            'tanggal_selesai' => '14 Februari 2026',
            'predikat'        => $predikat,
            'kepala_sekolah'  => 'Fajriadi, S.Pd., M.Pd',
        ];

        $pdf      = Pdf::loadView('penilaian.sertifikat.index_pdf', $data)->setPaper('a4', 'landscape');
        $filename = 'Sertifikat-PKL-' . str_replace(' ', '-', strtolower($user->name)) . '.pdf';

        return $pdf->download($filename);
    }
}