<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class IdukaController extends Controller
{
    public function index()
    {
        $idukas = Iduka::all();
        return view('iduka.dataiduka.dataiduka', compact('idukas'));
        // return view('iduka.dataiduka.index', compact('idukas'));
    }

    public function show($id)
    {
        $iduka = Iduka::findOrFail($id);
        return view('iduka.dataiduka.detailDataIduka', compact('iduka'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nama_pimpinan' => 'required|string|max:255',
            'nip_pimpinan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kode_pos' => 'required|string|max:10',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:idukas,email|unique:users,nip',
            'password' => 'required|string|min:6',
            'bidang_industri' => 'required|string',
            'kerjasama' => 'required|string',
            'kerjasama_lainnya' => 'nullable|required_if:kerjasama,Lainnya|string|max:255',
            'kuota_pkl' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // Simpan ke tabel idukas
            $kerjasama = $request->kerjasama === 'Lainnya' ? $request->kerjasama_lainnya : $request->kerjasama;
            $iduka = Iduka::create([
                'nama' => $request->nama,
                'nama_pimpinan' => $request->nama_pimpinan,
                'nip_pimpinan' => $request->nip_pimpinan,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'kode_pos' => $request->kode_pos,
                'telepon' => $request->telepon,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'bidang_industri' => $request->bidang_industri,
                'kerjasama' => $request->kerjasama,
                'kuota_pkl' => $request->kuota_pkl,
            ]);

            // Simpan ke tabel users
            User::create([
                'name' => $request->nama, // Masuk ke kolom name di users
                'nip' => $request->email, // Masuk ke kolom nip di users
                'password' => Hash::make($request->password), // Hashing password
                'role' => 'iduka', // Set default role sebagai 'iduka'
            ]);
        });



        return redirect()->back()->with('success', 'Data Iduka berhasil ditambahkan dan User berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nama_pimpinan' => 'required|string|max:255',
            'nip_pimpinan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kode_pos' => 'required|numeric',
            'telepon' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6',
            'bidang_industri' => 'required|string',
            'kerjasama' => 'required|string',
            'kerjasama_lainnya' => 'nullable|required_if:kerjasama,Lainnya|string|max:255',
            'kuota_pkl' => 'required|numeric',
        ]);

        $iduka = Iduka::findOrFail($id);
        $kerjasama = $request->kerjasama === 'Lainnya' ? $request->kerjasama_lainnya : $request->kerjasama;


        // Update data
        $iduka->update([
            'nama' => $request->nama,
            'nama_pimpinan' => $request->nama_pimpinan,
            'nip_pimpinan' => $request->nip_pimpinan,
            'jabatan' => $request->jabatan,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $iduka->password,
            'bidang_industri' => $request->bidang_industri,
            'kerjasama' => $request->kerjasama,
            'kuota_pkl' => $request->kuota_pkl,
        ]);

        return redirect()->route('data.iduka')->with('success', 'Data IDUKA berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $iduka = Iduka::findOrFail($id);

        DB::transaction(function () use ($iduka) {
            // Hapus user terkait di tabel users
            User::where('nip', $iduka->email)->delete();

            // Hapus data iduka dari database
            $iduka->delete();
        });

        return redirect()->route('data.iduka')->with('success', 'Data Iduka berhasil dihapus.');
    }
}
