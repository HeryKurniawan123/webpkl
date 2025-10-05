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

        // Ambil semua ATP berdasarkan konke_id
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

    public function cetakAtpLangsung()
    {
        $iduka_id = auth()->user()->iduka_id;

        // Ambil semua data IdukaAtp untuk IDUKA ini (baik yang dipilih maupun tidak)
        $idukaAtps = IdukaAtp::with(['atp.cp.konke'])
            ->where('iduka_id', $iduka_id)
            ->get()
            ->groupBy('atp.cp.konke.name_konke');

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <title>Cetak Tujuan Pembelajaran</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 20px; }
                .konke { font-weight: bold; margin-bottom: 10px; font-size: 16px; }
                .cp { font-weight: bold; margin-left: 20px; margin-bottom: 5px; font-size: 14px; }
                .atp { margin-left: 40px; margin-bottom: 3px; display: flex; justify-content: space-between; align-items: center; }
                .checkbox-container { width: 20px; }
                .checkbox { display: inline-block; width: 18px; height: 18px; border: 2px solid #28a745; border-radius: 4px; background-color: #28a745; position: relative; }
                .checkbox.unchecked { background-color: white; border-color: #ccc; }
                .checkbox.checked::after { content: "\\2713"; color: white; font-weight: bold; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
                .atp-content { flex-grow: 1; margin-right: 10px; }
                @media print {
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="header no-print">
                <h2>Tujuan Pembelajaran</h2>
                <p>' . date('d-m-Y') . '</p>
            </div>';

        if ($idukaAtps->isEmpty()) {
            $html .= '<div class="text-center">Tidak ada data untuk dicetak</div>';
        } else {
            foreach ($idukaAtps as $konkeName => $items) {
                $html .= '<div class="konke">' . $konkeName . '</div>';

                // Group by CP
                $groupedByCp = $items->groupBy('atp.cp.cp');

                foreach ($groupedByCp as $cpName => $atpItems) {
                    $html .= '<div class="cp">' . $cpName . '</div>';

                    foreach ($atpItems as $item) {
                        $isChecked = $item->is_selected ? 'checked' : 'unchecked';
                        $html .= '<div class="atp">
                            <div class="atp-content"><b>' . $item->atp->kode_atp . '</b> ' . $item->atp->atp . '</div>
                            <div class="checkbox-container">
                                <div class="checkbox ' . $isChecked . '"></div>
                            </div>
                        </div>';
                    }
                }
            }
        }

        $html .= '
            <script>
                window.onload = function() {
                    window.print();
                    window.onafterprint = function() {
                        window.close();
                    };
                }
            </script>
        </body>
        </html>';

        return response($html);
    }
}
