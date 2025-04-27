<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PercetakanAtpController extends Controller
{
    public function index()
    {
        $iduka = Iduka::orderBy('created_at', 'desc')->paginate(10);

        return view('iduka.dataiduka.cetakatp', compact('iduka'));
    }
    public function show($id)
    {
        $iduka = Iduka::where('id', $id)->first();

        return view('iduka.dataiduka.detailpersuratan', compact('iduka'));
    }

    public function downloadAtpIduka($id)
    {
        $iduka = Iduka::with(['atps.konke', 'atps.cp', 'atps.atp'])
            ->findOrFail($id);

        return Pdf::loadView('persuratan.suratPengajuan.kaprogatp', compact('iduka'))
            ->download('Data_ATP_' . $iduka->nama . '.pdf');
    }
}
