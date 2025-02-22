<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Konke;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function dataguru()
    {
        $gurus = Guru::with('konke')->paginate(10); // Mengambil data guru beserta relasinya ke konke
        $konkes = Konke::all(); // Mengambil seluruh data konkes
        return view('hubin.dataguru.dataguru', compact('gurus', 'konkes')); // Kirim ke view
    }

    public function create()
    {
        $konkes = Konke::all();
        return view('hubin.dataguru.create', compact('konkes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:gurus,nik',
            'email' => 'required|string|email|unique:gurus,email',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'password' => 'required|string|min:6',
            'konkes_id' => 'required|exists:konkes,id',
        ]);

        DB::transaction(function () use ($request) {
            // Simpan data ke tabel Guru
            $guru = Guru::create([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'nip' => $request->nip,
                'email' => $request->email,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
                'konkes_id' => $request->konkes_id,
            ]);

            // Simpan data ke tabel Users
            User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'nip' => $request->nik,
                'password' => Hash::make($request->password),
                'role' => 'guru', // Tambahkan jika ada role
            ]);
        });

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil ditambahkan!');
    }

    public function edit(Guru $guru)
    {
        $konkes = Konke::all();  // Fetch all records from the Konke model
        return view('hubin.dataguru.edit', compact('guru', 'konkes'));  // Pass the konkes variable to the view along with guru
    }


    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:gurus,nik,' . $guru->id,
            'email' => 'required|string|email|unique:gurus,email,' . $guru->id,
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'konkes_id' => 'required|exists:konkes,id',
        ]);

        DB::transaction(function () use ($request, $guru) {
            // Update data di tabel Guru
            $guru->update($request->except('password'));

            if ($request->password) {
                $guru->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Update data di tabel Users
            $user = User::where('email', $guru->email)->first();
            if ($user) {
                $user->update([
                    'name' => $request->nama,
                    'nip' => $request->nik,
                    'email' => $request->email,
                ]);

                if ($request->password) {
                    $user->update([
                        'password' => Hash::make($request->password),
                    ]);
                }
            }
        });

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru)
    {
        DB::transaction(function () use ($guru) {
            // Hapus data dari tabel Users
            User::where('email', $guru->email)->delete();
    
            // Hapus data dari tabel Guru
            $guru->delete();
        });
    
        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil dihapus!');
    }
    
}
