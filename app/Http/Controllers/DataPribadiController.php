<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataPribadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DataPribadiController extends Controller
{
    public function create()
    {
        $dataPribadi = Auth::user()->dataPribadi ?? new DataPribadi();
        $siswa = User::with('siswa')->where('id', Auth::id())->first();
        return view('siswa.data_pribadi.form', compact('dataPribadi', 'siswa'));
    }
    

    public function store(Request $request)
    {
        $dataPribadi = Auth::user()->dataPribadi;

        $request->validate([
            'name' => 'required|string|max:255',
          'nip' => 'required|unique:data_pribadis,nip,' . ($dataPribadi->id ?? 'null') . ',id',
            'konsentrasi_keahlian' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'email' => 'required|email|unique:data_pribadis,email,' . ($dataPribadi->id ?? 'null') . ',id',

            'name_ayh' => 'required|string|max:255',
            'name_ibu' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email_ortu' => 'required|email|unique:data_pribadis,email,' . ($dataPribadi->id ?? 'null') . ',id',
            'no_tlp' => 'required|string|max:15',
        ]);

        $data = array_merge(
            $request->all(),
            ['user_id' => Auth::id()]
        );

        if (!$dataPribadi) {
            $dataPribadi = DataPribadi::create($data);
        } else {
            $dataPribadi->update($data);
        }

        return redirect()->route('siswa.data_pribadi.create')
        ->with('success', 'Data pribadi berhasil disimpan.')
        ->withInput(); // Menyimpan input yang sudah diisi
    }

    public function show()
    {
        $dataPribadi = Auth::user()->dataPribadi;
        return view('siswa.data_pribadi.detail', compact('dataPribadi'));
    }

    public function update(Request $request, $id)
{
    $dataPribadi = DataPribadi::findOrFail($id);

    $request->validate([
        'name_ayh' => 'required|string|max:255',
        'name_ibu' => 'required|string|max:255',
        'nik' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'email_ortu' => 'required|email|unique:data_pribadis,email_ortu,' . $dataPribadi->id,
        'no_tlp' => 'required|string|max:15',
    ]);

    $dataPribadi->update($request->only([
        'name_ayh',
        'name_ibu',
        'nik',
        'alamat',
        'email_ortu',
        'no_tlp'
    ]));

    return redirect(url()->previous())->with('success', 'Data siswa berhasil diperbarui.');
}

} 