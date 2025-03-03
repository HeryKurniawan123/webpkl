<?php

namespace App\Http\Controllers;

use App\Models\Cp;
use App\Models\Atp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CpAtpController extends Controller
{
    // Menampilkan semua CP berdasarkan Kaprog yang sedang login
    public function cp()
    {
        $kaprog = Auth::user()->guru;
    
        if (!$kaprog || !$kaprog->konkes_id) {
            abort(403, 'Akses ditolak: Anda tidak memiliki Konsentrasi Keahlian.');
        }
    
        // Ambil semua Konsentrasi Keahlian yang dimiliki Kaprog
        $konke = \App\Models\Konke::where('id', $kaprog->konkes_id)->with('cp.atp')->get();
    
        return view('kaprog.cp.cp', compact('konke'));
    }
    

    // Menyimpan CP dan ATP
    public function store(Request $request)
    {
        $request->validate([
            'cp' => 'required|array',
            'cp.*' => 'required|string',
            'atp' => 'required|array',
            'atp.*' => 'required|array',
            'atp.*.*' => 'required|string',
        ]);
    
        $kaprog = Auth::user()->guru;
    
        if (!$kaprog || !$kaprog->konkes_id) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak memiliki Konsentrasi Keahlian.');
        }
    
        try {
            foreach ($request->cp as $cpIndex => $cpText) {
                // Hitung nomor CP berdasarkan urutan dalam input
                $cpNumber = $cpIndex + 1;
    
                // Simpan CP
                $cp = Cp::create([
                    'konkes_id' => $kaprog->konkes_id,
                    'cp' => $cpText,
                ]);
    
                // Simpan ATP berdasarkan CP yang sesuai
                if (isset($request->atp[$cpNumber])) {
                    foreach ($request->atp[$cpNumber] as $atpIndex => $deskripsi_atp) {
                        $atpNumber = "{$cpNumber}." . ($atpIndex + 1);
                        $cp->atp()->create([
                            'atp' => $deskripsi_atp,
                            'kode_atp' => $atpNumber,
                        ]);
                    }
                }
            }
    
            return redirect()->route('cp.index')->with('success', 'CP dan ATP berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

    // Update CP dan ATP
    public function update(Request $request, $id)
    {
        $request->validate([
            'cp' => 'required|string',
            'atp' => 'required|array',
            'atp.*' => 'required|string',
        ]);

        try {
            $cp = Cp::findOrFail($id);
            $cp->update(['cp' => $request->cp]);

            // Hapus ATP lama
            $cp->atp()->delete();

            // Hitung ulang nomor ATP
            $cpNumber = $cp->id;
            foreach ($request->atp as $index => $deskripsi_atp) {
                $atpNumber = "{$cpNumber}." . ($index + 1);
                $cp->atp()->create([
                    'atp' => $deskripsi_atp,
                    'kode_atp' => $atpNumber,
                ]);
            }

            return redirect()->route('cp.index')->with('success', 'CP dan ATP berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Hapus CP dan ATP
    public function destroy($id)
    {
        try {
            $cp = Cp::findOrFail($id);
            $cp->delete();

            return redirect()->route('cp.index')->with('success', 'CP dan ATP berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
