<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Iduka;

class LaporanIdukaExport implements FromView
{
    protected $iduka;
    protected $siswa;

    public function __construct($iduka)
    {
        $this->iduka = $iduka;
        $this->siswa = $iduka->siswa ?? collect();
    }

    public function view(): View
    {
        return view('hubin.laporan_iduka.export', [
            'iduka' => $this->iduka,
            'siswa' => $this->siswa
        ]);
    }
}
