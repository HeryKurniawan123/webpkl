<?php

namespace App\Http\Controllers;

use App\Models\Atp;
use App\Models\Cp;
use App\Models\Iduka;
use App\Models\IdukaAtp;
use App\Models\Konke;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    Log::info('Request Data:', $request->all());

    $request->validate([
        'konke_id' => 'required',
    ]);

    $iduka_id = auth()->user()->iduka_id ?? null;
    if (!$iduka_id) {
        return back()->withErrors(['error' => 'IDUKA tidak ditemukan untuk user ini.']);
    }

    // Ambil semua ATP berdasarkan konkes_id
    $allAtp = Atp::whereHas('cp', function ($query) use ($request) {
        $query->where('konke_id', $request->konke_id);
    })->get();
    

    foreach ($allAtp as $atp) {
        IdukaAtp::updateOrCreate(
            [
                'iduka_id' => $iduka_id,
                'konke_id' => $request->konke_id,
                'cp_id' => $atp->cp_id,
                'atp_id' => $atp->id,
            ],
            [
                'is_selected' => in_array($atp->id, $request->tp_check ?? []) ? true : false,
            ]
        );
    }

    return redirect()->back()->with('success', 'Tujuan Pembelajaran berhasil disimpan.');
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