<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = User::where('role', 'siswa')->get();

        return view('siswa.datasiswa.datasiswa', compact('siswa'));
    }

    public function show($id)
    {
        $siswa = User::with('dataPribadi')->findOrFail($id);
        $dataPribadi = User::with('dataPribadi')->where('id', Auth::id())->first();
        return view('siswa.datasiswa.detailSiswa', compact('siswa', 'dataPribadi'));
    }
    


    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|unique:users,nip',
            'kelas' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'kelas' => $request->kelas,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa'
        ]);
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }



    public function update(Request $request, $id)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => "required|unique:users,nip,$id",
            'kelas' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'password' => 'nullable|min:6',
        ]);

        $siswa = User::findOrFail($id);

        $siswa->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'kelas' => $request->kelas,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $siswa->password,
        ]);

        return redirect(url()->previous())->with('success', 'Data siswa berhasil diperbarui.');

    }


    public function destroy($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return back()->with('success', 'Data siswa berhasil diimport!');
    }

    public function dataPribadi()
    {
        $siswa = User::where('role', 'siswa')
            ->with('dataPribadi') 
            ->get();

        return view('admin.datasiswa.detailSiswa', compact('siswa'));
    }
}
