<?php

namespace App\Http\Controllers;

use App\Models\Atp;
use App\Models\Cp;
use App\Models\Iduka;
use App\Models\IdukaAtp;
use App\Models\Konke;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdukaAtpController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');
    $idukaAtps = IdukaAtp::with(['cp', 'atp'])
        ->where('iduka_id', Auth::user()->iduka_id)
        ->when($search, function ($query) use ($search) {
            return $query->whereHas('cp', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        })
        ->get();

    $konkes = Konke::all();
    $cps = Cp::all();
    $atps = Atp::all();

    return view('iduka.tp.tp', compact('idukaAtps', 'konkes', 'cps', 'atps'));
}

    

    public function store(Request $request)
{
    $request->validate([
        'iduka_id' => 'required|exists:idukas,id',
        'tp_check' => 'required|array',
        'tp_check.*' => 'exists:atps,id',
    ]);

    foreach ($request->tp_check as $atp_id) {
        // Ambil CP terkait dari ATP
        $atp = Atp::findOrFail($atp_id);
        $cp_id = $atp->cp_id;

        IdukaAtp::create([
            'iduka_id' => $request->iduka_id,
            'cp_id' => $cp_id,
            'atp_id' => $atp_id
        ]);
    }

    return redirect()->back()->with('success', 'Tujuan Pembelajaran berhasil ditambahkan.');
}



    public function update(Request $request, $id)
    {
        $request->validate([
            'iduka_id' => 'required|exists:idukas,id',
            'cp_id' => 'required|exists:cps,id',
            'atp_id' => 'required|exists:atps,id',
        ]);

        $idukaAtp = IdukaAtp::findOrFail($id);
        $idukaAtp->update($request->all());

        return redirect()->back()->with('success', 'Tujuan Pembelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        IdukaAtp::destroy($id);
        return redirect()->back()->with('success', 'Tujuan Pembelajaran berhasil dihapus.');
    }

    public function show($iduka_id)
{
    // Ambil IDUKA
    $iduka = Iduka::findOrFail($iduka_id);

    // Ambil semua CP dan ATP terkait kompetensi keahlian IDUKA
    $cp_atps = Cp::whereHas('atps')->with('atps')->get();

    // Ambil ATP yang sudah dipilih IDUKA
    $selected_atps = IdukaAtp::where('iduka_id', $iduka_id)->pluck('atp_id')->toArray();

    return view('iduka.tp.tp_show', compact('iduka', 'cp_atps', 'selected_atps'));
}

}
