<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DataPribadiPersuratan;

class DataPribadiPersuratanController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $persuratan = $user->load(['dataPersuratan']);
        $dataPersuratan = DataPribadiPersuratan::where('user_id', $user->id)->first();
        
        return view('persuratan.data_pribadi.form', compact('persuratan', 'dataPersuratan'));
    }

    public function store(Request $request)
    {
        $dataPersuratan = Auth::user()->dataPersuratan;
        $user = Auth::user(); // Ambil data user yang sedang login

        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|unique:data_pribadi_persuratans,nip,' . ($dataPersuratan->id ?? 'null') . ',id',
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric|unique:data_pribadi_persuratans,no_hp,' . ($dataPersuratan->id ?? 'null') . ',id',
            'jk' => 'required|string',
            'agama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'nullable|date',
            'email' => 'required|email|unique:data_pribadi_persuratans,email,' . ($dataPersuratan->id ?? 'null') . ',id',
            // Hapus validasi untuk password jika tidak diperlukan
        ]);

        // Data untuk tabel data_pribadi_persuratans
        $data = $request->except(['password']); // Exclude password dari data array

        // Jika password diisi, maka kita akan meng-update password
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $data['user_id'] = Auth::id();

        // Update atau create data di tabel data_pribadi_persuratans
        if (!$dataPersuratan) {
            $dataPersuratan = DataPribadiPersuratan::create($data);
        } else {
            $dataPersuratan->update($data);
        }

        // Update data di tabel users
        $userData = [
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
        ];

        // Jika password diisi, update password di tabel users
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        $user->update($userData);

        return redirect()->back()
        ->with('success', 'Data pribadi berhasil disimpan.')
        ->withInput(); // Menyimpan input yang sudah diisi
    }

}
