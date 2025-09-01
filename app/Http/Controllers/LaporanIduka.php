<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanIdukaExport;
use App\Exports\LaporanIdukaAllExport;

class LaporanIduka extends Controller
{
    /**
     * Tampilkan daftar IDUKA dengan pagination (untuk tampilan web).
     */
    public function index(Request $request)
    {
        $query = Iduka::with('siswa');

        // Filter nama IDUKA
        if ($request->filled('nama_iduka')) {
            $query->where('nama', 'like', '%' . $request->nama_iduka . '%');
        }

        $idukas = $query->paginate(10);

        return view('laporan_iduka.index', compact('idukas'));
    }

    /**
     * Tampilkan daftar siswa per IDUKA.
     */
    public function showSiswa($id)
    {
        $iduka = Iduka::with('siswa')->findOrFail($id);
        return view('laporan_iduka.siswa', compact('iduka'));
    }

    /**
     * Export siswa per IDUKA ke Excel.
     */
    public function exportExcel($id)
    {
        $iduka = Iduka::with('siswa')->findOrFail($id);

        return Excel::download(
            new LaporanIdukaExport($iduka),
            'laporan_iduka_' . $iduka->nama . '.xlsx'
        );
    }

    /**
     * Export semua IDUKA + siswa ke Excel.
     */
    public function exportAll()
    {
        return Excel::download(
            new LaporanIdukaAllExport,
            'laporan_iduka.xlsx'
        );
    }
}
