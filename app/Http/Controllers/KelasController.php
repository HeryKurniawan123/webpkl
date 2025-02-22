<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Konke;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('konke')->get();
        $konke = Konke::all();

        return view('data.kelas.dataKelas', compact('kelas', 'konke'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required|in:X,XI,XII',
            'konke_id' => 'required|exists:konkes,id',
            'name_kelas' => 'required|string|max:255',
        ]);

        Kelas::create([
            'kelas' => $request->kelas,
            'konke_id' => $request->konke_id,
            'name_kelas' => $request->name_kelas,
        ]);

        return redirect()->back()->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function showSiswa($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas = Kelas::all();
        $konke = Konke::all();
        $siswa = User::all();
        $siswa = User::where('kelas_id', $id)->get(); // Sesuaikan dengan struktur tabelmu
        return view('siswa.datasiswa.showSiswa', compact('kelas', 'siswa', 'konke'));
    }


    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'kelas' => 'required|in:X,XI,XII',
            'konke_id' => 'required|exists:konkes,id',
            'name_kelas' => 'required|string|max:255',
        ]);


        $kelas->update([
            'kelas' => $request->kelas,
            'konke_id' => $request->konke_id,
            'name_kelas' => $request->name_kelas
        ]);

        return redirect()->back()->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()->back()->with('success', 'Data kelas berhasil dihapus.');
    }
}
