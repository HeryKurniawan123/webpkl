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
    
        // Update atau buat user siswa (Auth user)
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'kelas_id' => $request->kelas_id,
            'konke_id' => $request->konke_id,
        ]);
    
        // Coba cari user orang tua berdasarkan email lama atau baru
        $userOrtu = User::where('email', $dataPribadi->email_ortu ?? $request->email_ortu)->first();
    
        if ($userOrtu) {
            $userOrtu->update([
                'name' => $request->name_ibu,
                'nip' => $request->nik_ibu,
                'email' => $request->email_ortu,
            ]);
        } else {
            User::create([
                'name' => $request->name_ibu,
                'nip' => $request->nik_ibu,
                'email' => $request->email_ortu,
                'password' => Hash::make($request->password), // Ganti kalau perlu
                'role' => 'orangtua',
            ]);
        }
    
        $data = array_merge($request->all(), ['user_id' => Auth::id()]);
    
        if (!$dataPribadi) {
            $dataPribadi = DataPribadi::create($data);
        } else {
            $dataPribadi->update($data);
        }
    
        return redirect()->route('siswa.data_pribadi.create')
            ->with('success', 'Data pribadi berhasil disimpan.')
            ->withInput();
    }
    

   
    

} 