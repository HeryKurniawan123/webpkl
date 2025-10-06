<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use Illuminate\Http\Request;

class DaftarIdukaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari request
        $search = $request->input('search');

        // Query dasar untuk tabel iduka
        $query = Iduka::query();

        // Jika ada parameter pencarian, tambahkan kondisi where
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Tambahkan paginasi (10 data per halaman)
        $data = $query->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString(); // Mempertahankan parameter pencarian saat paginasi

        return view('hubin.iduka.daftar', compact('data', 'search'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'radius' => 'nullable|integer|min:0',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
        ]);

        $iduka = Iduka::findOrFail($id);
        $iduka->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data IDUKA berhasil diperbarui.'
        ]);
    }
}
