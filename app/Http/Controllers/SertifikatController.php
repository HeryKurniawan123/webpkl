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

        // Extract kota from alamat if possible, or fallback to 'Kawali'
        $alamat = $user->iduka->alamat ?? '';
        $kotaIduka = 'Kawali'; 
        
        if (preg_match('/(?:Kab\.|Kabupaten|Kota)\s*([^,]+)/i', $alamat, $matches)) {
            $kotaIduka = trim($matches[1]);
        } elseif (stripos($alamat, 'Ciamis') !== false) {
            $kotaIduka = 'Ciamis';
        } elseif (stripos($alamat, 'Bandung') !== false) {
            $kotaIduka = 'Bandung';
        }

        $tglLahir = $user->dataPribadi->tgl_lahir ?? null;
        if ($tglLahir) {
            $tglLahir = \Carbon\Carbon::parse($tglLahir)->translatedFormat('d F Y');
        } else {
            $tglLahir = '-';
        }

        $data = [
            'nama'            => $user->name,
            'nis'             => $user->nip ?? ($user->dataPribadi->nip ?? '-'),
            'tempat_lahir'    => $user->dataPribadi->tempat_lhr ?? '-',
            'tgl_lahir'       => $tglLahir,
            'tahun_ajaran'    => $user->tahun_ajaran ?? '-',
            'asal_sekolah'    => 'SMKN 1 Kawali',
            'konsentrasi'     => $user->konke->name_konke ?? 'Konsentrasi Belum Diatur',
            'lama'            => '4 bulan',
            'tanggal_mulai'   => '13 Oktober 2025',
            'tanggal_selesai' => '14 Februari 2026',
            'predikat'        => $predikat,
            'kepala_sekolah'  => 'DEDE FAJRIADI, S.Pd., M.Pd',
            'nama_iduka'      => $user->iduka->nama ?? 'NAMA IDUKA',
            'foto_iduka'      => $user->iduka->foto ?? null,
            'alamat_iduka'    => $user->iduka->alamat ?? 'ALAMAT IDUKA',
            'kota_iduka'      => $kotaIduka,
            'nama_pimpinan'   => $user->iduka->nama_pimpinan ?? 'Nama Pimpinan',
        ];

        $pdf      = Pdf::loadView('penilaian.sertifikat.index_pdf', $data)->setPaper('a4', 'landscape');
        $filename = 'Sertifikat-PKL-' . str_replace(' ', '-', strtolower($user->name)) . '.pdf';

        return $pdf->download($filename);
    }
}