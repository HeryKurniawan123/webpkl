<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;

class SertifikatController extends Controller
{
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
            'konsentrasi'     => $user->konke->name_konke ?? 'Konsentrasi Belum Diatur',
            'lama'            => '4 bulan',
            'tanggal_mulai'   => '13 Oktober 2025',
            'tanggal_selesai' => '14 Februari 2026',
            'predikat'        => $predikat,
            'kepala_sekolah'  => 'DEDE FAJRIADI, S.Pd., M.Pd',
            'nama_iduka'      => $user->iduka->nama ?? 'NAMA IDUKA',
            'foto_iduka'      => $user->iduka->foto ?? null,
        ];

        $pdf      = Pdf::loadView('penilaian.sertifikat.index_pdf', $data)->setPaper('a4', 'landscape');
        $filename = 'Sertifikat-PKL-' . str_replace(' ', '-', strtolower($user->name)) . '.pdf';

        return $pdf->download($filename);
    }
}