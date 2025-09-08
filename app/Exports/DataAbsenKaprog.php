<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class DataAbsenKaprog implements FromView
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function view(): View
    {
        $kaprog = Auth::user();
        $konkeId = $kaprog->konke_id;

        $dataAbsensi = Absensi::with('user.kelas')
            ->whereDate('tanggal', $this->tanggal)
            ->whereHas('user', function ($q) use ($konkeId) {
                $q->where('konke_id', $konkeId);
            })
            ->orderBy('user_id')
            ->get();

        return view('kaprog.absensi.index', [
            'dataAbsensi' => $dataAbsensi,
            'tanggal' => $this->tanggal
        ]);
    }
}
