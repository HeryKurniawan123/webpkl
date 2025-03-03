<?php

namespace App\Http\Controllers;

use App\Models\IdukaAtp;
use App\Models\Konke;
use Illuminate\Http\Request;

class IdukaAtpController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $idukaAtps = IdukaAtp::with(['iduka', 'cp', 'atp'])
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('cp', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->get();
            $konkes = Konke::all(); // Ambil semua jurusan dari tabel konkes

        return view('iduka.tp.tp', compact('idukaAtps', 'konkes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'iduka_id' => 'required|exists:idukas,id',
            'cp_id' => 'required|exists:cps,id',
            'atp_check' => 'array', // ATP yang dicentang
            'atp_check.*' => 'exists:atps,id', // Validasi bahwa yang dicentang ada di tabel ATP
        ]);
    
        $iduka_id = $request->iduka_id;
        $cp_id = $request->cp_id;
        $selectedAtps = $request->atp_check ?? []; // ATP yang dicentang
        $allAtps = \App\Models\Atp::where('cp_id', $cp_id)->pluck('id')->toArray(); // Semua ATP berdasarkan CP
    
        foreach ($allAtps as $atp_id) {
            IdukaAtp::create([
                'iduka_id' => $iduka_id,
                'cp_id' => $cp_id,
                'atp_id' => $atp_id,
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
    
    
}
