<?php

namespace App\Http\Controllers;

use App\Models\CetakUsulan;
use App\Models\SuratPengantar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SuratPengantarController extends Controller
{
    public function index()
    {
        $data = SuratPengantar::first(); // hanya ambil data pertama
        return view('pusatbantuan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required',
            'perihal' => 'required',
            'tempat' => 'required',
            'tanggalbuat' => 'required|date',
            'deskripsi' => 'required',
            'nama_instansi' => 'required',
            'nama_kepsek' => 'required',
        ]);

        $surat = SuratPengantar::first();

        if ($surat) {
            $surat->update($request->all());
        } else {
            SuratPengantar::create($request->all());
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function suratPengantarPDF($id)
    {
        $suratPengantar = SuratPengantar::first();

        $pengajuan = CetakUsulan::with([
            'dataPribadi.kelas',
            'dataPribadi.konkes',
            'iduka.user.pembimbingpkl',
            'iduka.konkes',
            'iduka.cp',
            'iduka.atps',

        ])->findOrFail($id);


        $data = [
            'pengajuan' => $pengajuan,
            'tanggal' => now()->format('d F Y'),
            'suratPengantar' => $suratPengantar,  // Mengirimkan satu data surat_pengantar
        ];

        $pdf = Pdf::loadView('surat_pengantar.surat_pengantarPDF', $data)
            ->setPaper('F4', 'portrait');

        return $pdf->download('surat-pengantar.pdf');
    }

    public function semuasurat($iduka_id)
    {
        $suratPengantar = SuratPengantar::first(); 
    
        // Ambil semua pengajuan untuk IDUKA ini
        $pengajuans = CetakUsulan::with([
            'dataPribadi.kelas',
            'dataPribadi.konkes',
            'iduka.user.pembimbingpkl',
            'iduka.konkes',
            'iduka.cp',
            'iduka.atps',
        ])
        ->where('iduka_id', $iduka_id)
        ->where('status', 'proses')
        ->get();
    
        // Jika kosong, redirect balik atau abort
        if ($pengajuans->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada pengajuan untuk IDUKA ini.');
        }
    
        $data = [
            'pengajuans' => $pengajuans,
            'tanggal' => now()->format('d F Y'),
            'suratPengantar' => $suratPengantar,
        ];
    
        $pdf = Pdf::loadView('surat_pengantar.surat_pengantarsemua', $data)
                  ->setPaper('F4', 'portrait');
    
        return $pdf->download('surat-pengantar.pdf');
    }
    
}
