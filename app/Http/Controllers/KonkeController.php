<?php 

namespace App\Http\Controllers;

use App\Models\Konke;
use App\Models\Proker;
use Illuminate\Http\Request;

class KonkeController extends Controller
{
    public function index()
    {
        $konke = Konke::with('proker')->get();
        $proker = Proker::all();

        return view('data.konke.dataKonke', compact('konke', 'proker'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_konke' => 'required|string|max:255',
            'proker_id' => 'required|exists:prokers,id'
        ]);

        Konke::create([
            'name_konke' => $request->name_konke,
            'proker_id' => $request->proker_id
        ]);

        return redirect()->back()->with('success', 'Data Konsentrasi Keahlian berhasil ditambahkan.');
    }

    public function update(Request $request, Konke $konke)
    {
        $request->validate([
            'name_konke' => 'required|string|max:255',
            'proker_id' => 'required|exists:prokers,id'
        ]);

        $konke->update([
            'name_konke' => $request->name_konke,
            'proker_id' => $request->proker_id
        ]);

        return redirect()->back()->with('success', 'Data Konsentrasi Keahlian berhasil diperbarui.');
    }

    public function destroy(Konke $konke)
    {
        $konke->delete();

        return redirect()->back()->with('success', 'Data Konsentrasi Keahlian berhasil dihapus.');
    }
}
