<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataAbsenKaprog implements FromView
{
    protected $data;
    protected $tanggal;

    public function __construct($data, $tanggal)
    {
        $this->data = $data;
        $this->tanggal = $tanggal;
    }

    public function view(): View
    {
        return view('kaprog.absensi.export', [
            'absensi' => $this->data,
            'tanggal' => $this->tanggal
        ]);
    }
}

