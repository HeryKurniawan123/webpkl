<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Iduka;
use App\Models\Pembimbing;
use Illuminate\Http\Request;
use App\Models\PembimbingIduka;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class IdukaController extends Controller
{
    public function index()
    {
   
        $iduka = Iduka::all();
        return view('iduka.dataiduka.dataiduka', compact('iduka'));
    }

    public function dataPribadiIduka()
    {
        // Ambil user yang sedang login
        $user = auth()->user();
    
        // Ambil data Iduka dan Pembimbing terkait
        $iduka = Iduka::where('user_id', $user->id)->first();
        $pembimbing = Pembimbing::where('user_id', $user->id)->first();
    
        return view('iduka.data_pribadi_iduka.dataPribadiIduka', compact('iduka', 'pembimbing'));
    }
    
    
    public function edit()
    {
        $user = auth()->user();
        $iduka = Iduka::where('user_id', $user->id)->first();
        $pembimbing = Pembimbing::where('user_id', $user->id)->first();
    
        return view('iduka.data_pribadi_iduka.editPribadiIduka', compact('iduka', 'pembimbing'));
    }

    public function updatePribadi(Request $request, $id)
    {
        $iduka = Iduka::findOrFail($id);
        $pembimbing = Pembimbing::where('user_id', $iduka->user_id)->first(); // Ambil data pembimbing
    
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
            'no_hp_pimpinan' =>  'required|numeric',
        ]);
    
        DB::transaction(function () use ($request, $iduka, $pembimbing) {
            // Update Iduka
            $iduka->update([
                'nama' => $request->nama,
                'nama_pimpinan' => $request->nama_pimpinan,
                'nip_pimpinan' => $request->nip_pimpinan,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'kode_pos' => $request->kode_pos,
                'telepon' => $request->telepon,
                'email' => $request->email,
              
                'bidang_industri' => $request->bidang_industri,
                'kerjasama' => $request->kerjasama,
                'kerjasama_lainnya' => $request->kerjasama_lainnya,
                'kuota_pkl' => $request->kuota_pkl,
                'no_hp_pimpinan' => $request->no_hp_pimpinan,

              
            ]);
    
            // Update atau buat data Pembimbing
            if ($pembimbing) {
                $pembimbing->update([
                    'name' => $request->nama_pembimbing,
                    'nip' => $request->nip_pembimbing,
                    'no_hp' => $request->no_hp_pembimbing,
                ]);
            } else {
                Pembimbing::create([
                    'user_id' => $iduka->user_id,
                    'name' => $request->nama_pembimbing,
                    'nip' => $request->nip_pembimbing,
                    'no_hp' => $request->no_hp_pembimbing,
                ]);
            }
        });
    
        return redirect()->route('iduka.data-pribadi')->with('success', 'Data berhasil diperbarui.');
    }
    
    
    

    

    public function show($id)
    {
        $iduka = Iduka::where('id', $id)->first();

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
            'rekomendasi' => 'nullable|boolean',
            'no_hp_pimpinan' => 'required|string|max:15',
        ]);
    
        DB::transaction(function () use ($request) {
            // Simpan ke tabel users terlebih dahulu
            $user = User::create([
                'name' => $request->nama,
                'nip' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'iduka',
            ]);
        
            // Simpan ke tabel idukas
            DB::table('idukas')->insert([
                'user_id' => $user->id,
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
                'kerjasama' => $request->kerjasama === 'Lainnya' ? $request->kerjasama_lainnya : $request->kerjasama,
                'kerjasama_lainnya' => $request->kerjasama_lainnya,
                'kuota_pkl' => $request->kuota_pkl,
                'rekomendasi' => $request->rekomendasi ?? 0,
                'no_hp_pimpinan' => $request->no_hp_pimpinan,
                'created_at' => now(),
                'updated_at' => now(),
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
            'no_hp_pimpinan' =>  'required|numeric',
        ]);

        $iduka = Iduka::findOrFail($id);
        $kerjasama = $request->kerjasama === 'Lainnya' ? $request->kerjasama_lainnya : $request->kerjasama;
        $rekomendasi = $request->has('rekomendasi') ? 1 : 0;

        DB::transaction(function () use ($request, $iduka) {
            if ($iduka->user) {
                $iduka->user->update([
                    'name' => $request->nama,
                    'nip' => $request->email,
                    'password' => $request->password ? Hash::make($request->password) : $iduka->user->password,
                    'role' => 'iduka',
                ]);
            }
        
            $iduka->update([
                'nama' => $request->nama,
                'nama_pimpinan' => $request->nama_pimpinan,
                'nip_pimpinan' => $request->nip_pimpinan,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'kode_pos' => $request->kode_pos,
                'telepon' => $request->telepon,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $iduka->password,
                'bidang_industri' => $request->bidang_industri,
                'kerjasama' => $request->kerjasama,
                'kuota_pkl' => $request->kuota_pkl,
                'rekomendasi' => $request->rekomendasi ?? 0,
                'no_hp_pimpinan' => $request->no_hp_pimpinan,
            ]);
        });
        

        
        return redirect(url()->previous())->with('success', 'Data IDUKA berhasil diperbarui!');
    }




    public function destroy($id)
    {
        $iduka = Iduka::findOrFail($id);

        DB::transaction(function () use ($iduka) {
            if ($iduka->user) {
                $iduka->user->delete(); // Hapus user yang terkait langsung
            }
            $iduka->delete();
        });
        

        return redirect()->route('data.iduka')->with('success', 'Data Iduka berhasil dihapus.');
    }

    public function downloadPDF($id)
    {
       // Ambil user yang sedang login
       $user = auth()->user();
    
       // Ambil data Iduka dan Pembimbing terkait
       $iduka = Iduka::where('user_id', $user->id)->first();
       $pembimbing = Pembimbing::where('user_id', $user->id)->first();
        
    
        $pdf = Pdf::loadView('iduka.pdf_template', compact('iduka', 'pembimbing'))
                  ->setPaper('A4', 'portrait'); // Ukuran kertas A4 vertikal
    
        return $pdf->download('laporan_pridasi_iduka.pdf' . $user->id . '.pdf');
    }

    public function TpIduka() {
        return view('iduka.tp.tp');
    }
    
    
}
