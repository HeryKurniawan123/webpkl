<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use App\Models\DataPribadi;
use App\Models\UsulanIduka;
use App\Models\PengajuanUsulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsulanIdukaController extends Controller
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
        // Cek apakah sudah ada usulan aktif
        $cekUsulanAktif = UsulanIduka::where('user_id', $user->id)
            ->whereIn('status', ['proses', 'diterima'])
            ->exists();

        if ($cekUsulanAktif) {
            return redirect()->back()->with('error', 'Kamu sudah memiliki usulan yang sedang diproses atau sudah diterima.');
        }

        $dataPribadi = DataPribadi::where('user_id', $user->id)->first();

        if (!$dataPribadi) {
            return redirect()->route('siswa.data_pribadi.create') // arahkan ke form pengisian data pribadi
                ->with('error', 'Silakan lengkapi data pribadi terlebih dahulu sebelum mengajukan usulan.');
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


        return redirect()->route('siswa.dashboard')->with('success', 'Usulan berhasil diajukan.');
    }

    public function storeAjukanPkl(Request $request, $iduka_id)
    {
        \Log::info('StoreAjukanPkl called', [
            'user_id' => Auth::id(),
            'iduka_id' => $iduka_id,
            'request_data' => $request->all()
        ]);

        try {
            $user = Auth::user();
            $dataPribadi = DataPribadi::where('user_id', $user->id)->first();

            \Log::info('User and DataPribadi', [
                'user' => $user,
                'dataPribadi' => $dataPribadi
            ]);

            if (!$dataPribadi) {
                \Log::warning('Data pribadi tidak ditemukan', ['user_id' => $user->id]);
                return redirect()->back()->with('error', 'Data pribadi tidak ditemukan.');
            }

            // Validasi IDUKA exists
            $iduka = Iduka::find($iduka_id);
            if (!$iduka) {
                \Log::warning('IDUKA tidak ditemukan', ['iduka_id' => $iduka_id]);
                return redirect()->back()->with('error', 'IDUKA tidak ditemukan.');
            }

            // Cek apakah siswa sudah punya pengajuan PKL yang aktif
            $cekPengajuanAktif = PengajuanUsulan::where('user_id', $user->id)
                ->whereIn('status', ['proses', 'diterima'])
                ->exists();

            /**
             * LOGIKA UTAMA:
             * - Jika user TIDAK memiliki iduka_id (null) → BOLEH ajukan
             * - Jika user SUDAH memiliki iduka_id → TIDAK BOLEH ajukan baru
             * - Kecuali jika ingin pindah IDUKA, perlu mekanisme khusus
             */
            if ($cekPengajuanAktif && $user->iduka_id !== null) {
                \Log::warning('User sudah memiliki pengajuan aktif dan iduka_id tidak null', [
                    'user_id' => $user->id,
                    'iduka_id' => $user->iduka_id
                ]);
                return redirect()->back()->with('error', 'Kamu sudah memiliki pengajuan PKL yang sedang diproses atau sudah diterima.');
            }

            // Cek apakah sudah mengajukan ke IDUKA ini
            $cekUsulan = PengajuanUsulan::where('user_id', $user->id)
                ->where('iduka_id', $iduka_id)
                ->first();

            if ($cekUsulan) {
                \Log::warning('Sudah mengajukan ke IDUKA ini', [
                    'user_id' => $user->id,
                    'iduka_id' => $iduka_id,
                    'status_sebelumnya' => $cekUsulan->status
                ]);

                $message = 'Kamu sudah mengajukan PKL ke IDUKA ini.';
                if ($cekUsulan->status === 'ditolak') {
                    $message .= ' Pengajuan sebelumnya ditolak.';
                }

                return redirect()->back()->with('error', $message);
            }

            \Log::info('Creating PengajuanUsulan', [
                'user_id' => $user->id,
                'konke_id' => $dataPribadi->konke_id,
                'iduka_id' => $iduka_id,
                'user_iduka_null' => is_null($user->iduka_id)
            ]);

            // Simpan data
            $pengajuan = PengajuanUsulan::create([
                'user_id' => $user->id,
                'konke_id' => $dataPribadi->konke_id,
                'iduka_id' => $iduka_id,
                'status' => 'proses',
                'tanggal_pengajuan' => now(), // tambahkan timestamp
            ]);

            \Log::info('PengajuanUsulan created successfully', [
                'pengajuan_id' => $pengajuan->id,
                'user_previous_iduka' => $user->iduka_id
            ]);

            return redirect()->route('siswa.dashboard')->with('success', 'Usulan PKL berhasil diajukan!');

        } catch (\Exception $e) {
            \Log::error('Error in storeAjukanPkl', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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

    public function lihatPDF()
    {
        return view('data.usulan.suratUsulanPDF');
    }



    public function dataIdukaUsulan()
    {

        $today = Carbon::today();

        $iduka = Iduka::where('hidden', false) // Hanya tampilkan yang tidak hidden
            ->where(function ($query) use ($today) {
                $query->whereNull('akhir_kerjasama')
                    ->orWhere('akhir_kerjasama', '>=', $today);
            })
            ->orderBy('rekomendasi', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.usulan.dataIdukaUsulan', compact('iduka', 'today'));
    }



    public function detailIdukaUsulan($id)
    {
        $iduka = Iduka::where('id', $id)->first();

        return view('siswa.usulan.usulaniduka', compact('iduka'));
    }
}
