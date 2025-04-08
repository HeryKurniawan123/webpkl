<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use App\Models\DataPribadi;
use App\Models\UsulanIduka;
use App\Models\PengajuanUsulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class  UsulanIdukaController extends Controller
{
    public function index()
    {
        $usulanSiswa = UsulanIduka::where('user_id', Auth::id())->get();
        
        return view('data.usulan.formUsulan', compact('usulanSiswa'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nama_pimpinan' => 'required|string|max:255',
            'nip_pimpinan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kode_pos' => 'required|string|max:10',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:usulan_idukas,email',
            'bidang_industri' => 'required|string',
            'kerjasama' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $user = Auth::user();
        $dataPribadi = DataPribadi::where('user_id', $user->id)->first();

        if (!$dataPribadi) {
            return redirect()->back()->with('error', 'Data pribadi tidak ditemukan.');
        }

        UsulanIduka::create([
            'user_id' => $user->id,
            'konke_id' => $dataPribadi->konke_id, // Tambahkan konke_id
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
            'status' => 'proses',
            'iduka_id' => $request->iduka_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Usulan berhasil diajukan.');
    }

    public function storeAjukanPkl(Request $request, $iduka_id)
    {
        $user = Auth::user();
        $dataPribadi = DataPribadi::where('user_id', $user->id)->first();
        $iduka = Iduka::findOrFail($iduka_id);
        
        if (!$dataPribadi) {
            return redirect()->back()->with('error', 'Data pribadi tidak ditemukan.');
        }
    
        // Cek apakah siswa sudah mengajukan PKL ke IDUKA ini sebelumnya
        $cekUsulan = PengajuanUsulan::where('user_id', $user->id)
                                    ->where('iduka_id', $iduka_id)
                                    ->first();
    
        if ($cekUsulan) {
            return redirect()->back()->with('error', 'Kamu sudah mengajukan PKL ke IDUKA ini.');
        }
    
        // Simpan data ke tabel pengajuan_pkls, bukan usulan_idukas
        PengajuanUsulan::create([
            'user_id' => $user->id,
            'konke_id' => $dataPribadi->konke_id,
            'iduka_id' => $iduka_id,
            'status' => 'proses', // Status awal adalah "proses"
        ]);
    
        return redirect()->back()->with('success', 'Pengajuan PKL berhasil dikirim dan sedang menunggu persetujuan.');
    }
    

    public function approvePengajuanUsulan($id)
{
    $usulan = PengajuanUsulan::findOrFail($id);
    $usulan->update(['status' => 'diterima']);

    return redirect()->back()->with('success', 'Pengajuan PKL diterima.');
}

public function rejectPengajuanUsulan($id)
{
    $usulan = PengajuanUsulan::findOrFail($id);
    $usulan->update(['status' => 'ditolak']);

    return redirect()->back()->with('error', 'Pengajuan PKL ditolak.');
}




    public function approve($id)
    {
        $usulan = UsulanIduka::findOrFail($id);
        $usulan->update(['status' => 'diterima']);
        return redirect()->back()->with('success', 'Usulan diterima.');
    }

    public function reject($id)
    {
        $usulan = UsulanIduka::findOrFail($id);
        $usulan->update(['status' => 'ditolak']);
        return redirect()->back()->with('error', 'Usulan ditolak.');
    }

    public function lihatPDF() {
        return view('data.usulan.suratUsulanPDF');
    }

    public function dataIdukaUsulan()
    {
   
        $iduka = Iduka::orderBy('created_at', 'desc')->get(); 
        return view('siswa.usulan.dataIdukaUsulan', compact('iduka'));
    }

    public function detailIdukaUsulan($id)
    {
        $iduka = Iduka::where('id', $id)->first();

        return view('siswa.usulan.usulaniduka', compact('iduka'));
    }


}
