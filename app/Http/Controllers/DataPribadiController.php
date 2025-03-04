<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Konke;
use App\Models\DataPribadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DataPribadiController extends Controller
{
    public function create()
    {
        $dataPribadi = Auth::user()->dataPribadi ?? new DataPribadi();
        $siswa = User::with('siswa', 'kelas', 'konke')->where('id', Auth::id())->first();
        $konke = Konke::all();
        $kelas = Kelas::all();
        return view('siswa.data_pribadi.form', compact('dataPribadi', 'siswa', 'kelas', 'konke'));
    }
    

    public function store(Request $request)
    {
        $dataPribadi = Auth::user()->dataPribadi;

        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|unique:data_pribadis,nip,' . ($dataPribadi->id ?? 'null') . ',id',
            'kelas_id' =>  'nullable|exists:kelas,id',
            'konke_id' => 'nullable|exists:konkes,id',
            'alamat_siswa' => 'required|string',
            'no_hp' => 'required|numeric|unique:data_pribadis,no_hp,' . ($dataPribadi->id ?? 'null') . ',id',
            'jk' => 'required|string',
            'agama' => 'required|string',
            'tempat_lhr' => 'required|string',
            'tanggal_lahir' => 'nullable|date',
            'email' => 'required|email|unique:data_pribadis,email,' . ($dataPribadi->id ?? 'null') . ',id',

            'name_ayh' => 'required|string|max:255',
            'nik_ayh' => 'required|unique:data_pribadis,nik_ayh,' . ($dataPribadi->id ?? 'null') . ',id',
            'tempat_lhr_ayh' => 'required|string',
            'tanggal_lahir_ayh' => 'nullable|date',
            'pekerjaan_ayh' => 'nullable|string',

            'name_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|unique:data_pribadis,nik_ibu,' . ($dataPribadi->id ?? 'null') . ',id',
            'tempat_lhr_ibu' => 'required|string',
            'tanggal_lahir_ibu' => 'nullable|date',
            'pekerjaan_ibu' => 'nullable|string',

            'email_ortu' => 'required|email|unique:data_pribadis,email_ortu,' . ($dataPribadi->id ?? 'null') . ',id',
            'no_tlp' => 'required|string|max:15|unique:data_pribadis,no_tlp,' . ($dataPribadi->id ?? 'null') . ',id',
        ]);

        User::create([
            'name' => $request->name_ibu,
            'nip' => $request->nip_ibu,
            'password' => Hash::make($request->password),
            'role' => 'orangtua'
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

    public function update(Request $request, $id)
    {
        $dataPribadi = DataPribadi::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|unique:data_pribadis,nip,' .  $dataPribadi->id,
            'kelas_id' =>  'nullable|exists:kelas,id',
            'konke_id' => 'nullable|exists:konkes,id',
            'alamat_siswa' => 'required|string',
            'no_hp' => 'required|numeric|unique:data_pribadis,no_hp,' .  $dataPribadi->id,
            'jk' => 'required|string',
            'agama' => 'required|string',
            'tempat_lhr' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:data_pribadis,email,' .  $dataPribadi->id,
    
            'name_ayh' => 'required|string|max:255',
            'nik_ayh' => 'required|unique:data_pribadis,nik_ayh,' .  $dataPribadi->id,
            'tempat_lhr_ayh' => 'required|string',
            'tanggal_lahir_ayh' => 'required|date',
            'pekerjaan_ayh' => 'nullable|string',
    
            'name_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|unique:data_pribadis,nik_ibu,' .  $dataPribadi->id,
            'tempat_lhr_ibu' => 'required|string',
            'tanggal_lahir_ibu' => 'required|date',
            'pekerjaan_ibu' => 'nullable|string',
    
            'email_ortu' => 'required|email|unique:data_pribadis,email_ortu,' .  $dataPribadi->id,
            'no_tlp' => 'required|string|max:15|unique:data_pribadis,no_tlp,' .  $dataPribadi->id,
        ]);
    
        // Simpan email lama sebelum diupdate
        $oldEmail = $dataPribadi->email;
    
        // Update data pribadi
        $dataPribadi->update($request->only([
            'name',
            'nip',
            'konke_id',
            'kelas_id',
            'alamat_siswa',
            'no_hp',
            'jk',
            'agama',
            'tempat_lhr',
            'tanggal_lahir',
            'email',
    
            'name_ayh',
            'nik_ayh',
            'tempat_lhr_ayh',
            'tanggal_lahir_ayh',
            'pekerjaan_ayh',
    
            'name_ibu',
            'nik_ibu',
            'tempat_lhr_ibu',
            'tanggal_lahir_ibu',
            'pekerjaan_ibu',
    
            'email_ortu',
            'no_tlp',
        ]));
    
        // Update email di tabel users jika email berubah
        if ($oldEmail !== $request->email) {
            $user = User::where('email', $oldEmail)->first();
            if ($user) {
                $user->update([
                    'email' => $request->email,
                ]);
            }
        }
    
        // Update data user orang tua
        $userOrtu = User::where('email', $dataPribadi->email_ortu)->first();
    
        if ($userOrtu) {
            $userOrtu->update([
                'name' => $request->name_ibu, // atau name_ayh tergantung kebutuhan
                'nip' => $request->nik_ibu, // atau nik_ayh tergantung kebutuhan
                'email' => $request->email_ortu,
                // Jika ada field lain yang perlu diupdate, tambahkan di sini
            ]);
        }
    
        return redirect(url()->previous())->with('success', 'Data siswa dan orang tua berhasil diperbarui.');
    }

} 