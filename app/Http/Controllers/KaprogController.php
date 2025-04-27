<?php
//anjay
namespace App\Http\Controllers;

use App\Models\Cp;
use App\Models\Atp;
use App\Models\CetakUsulan;
use App\Models\User;
use App\Models\Iduka;
use App\Models\PengajuanPkl;
use App\Models\UsulanIduka;
use Illuminate\Http\Request;
use App\Models\PengajuanUsulan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;


class KaprogController extends Controller
{
    public function reviewUsulan()
    {
        $user = Auth::user();

        $kaprog = DB::table('gurus')->where('user_id', $user->id)->first();
        if (!$kaprog) {
            return redirect()->back()->with('error', 'Data Kaprog tidak ditemukan.');
        }

        $usulanIdukas = UsulanIduka::with(['user.dataPribadi.kelas'])
            ->where('status', 'proses')
            ->where('konke_id', $kaprog->konke_id)
            ->get();


        $groupedIduka = $usulanIdukas->groupBy('email'); // setiap group mewakili satu usulan IDUKA

        $pengajuanUsulans = PengajuanUsulan::with(['user.dataPribadi.kelas', 'iduka'])
            ->where('status', 'proses')
            ->where('konke_id', $kaprog->konke_id)
            ->get()
            ->groupBy('iduka_id');



        return view('kaprog.review.reviewusulan', compact('usulanIdukas', 'pengajuanUsulans', 'groupedIduka'));
    }


    public function detailPengajuanSiswa($pengajuanId)
    {
        $usulan = PengajuanUsulan::with(['user.dataPribadi.kelas', 'user.dataPribadi.konkes', 'iduka'])->findOrFail($pengajuanId);
        return view('kaprog.review.detailpengajuansiswa', compact('usulan'));
    }

    public function show($id)
    {
        $usulan = UsulanIduka::with(['user.dataPribadi.konkes', 'user.dataPribadi.kelas', 'iduka'])
            ->findOrFail($id);

        return view('kaprog.review.detailusulanpkl', compact('usulan'));
    }


    // public function showUsulan($id)
    // {
    //     $usulan = PengajuanUsulan::with(['user.dataPribadi.konkes', 'user.dataPribadi.kelas', 'iduka'])
    //         ->findOrFail($id);

    //     return view('kaprog.review.detailusulanpkl', compact('usulan'));
    // }

    // public function prosesPengajuan($id, Request $request): JsonResponse
    // {



    //     $pengajuan = PengajuanUsulan::findOrFail($id);

    //     if ($pengajuan->status === 'dikirim') {
    //         return response()->json(['message' => 'Pengajuan sudah dikirim sebelumnya.'], 409);
    //     }

    //     $pengajuan->update([
    //         'status' => 'dikirim',
    //     ]);

    //     // Cek apakah data sudah ada agar tidak dobel
    //     $existing = PengajuanPkl::where('siswa_id', $pengajuan->user_id)
    //         ->where('iduka_id', $request->iduka_id)
    //         ->first();

    // 
    //         PengajuanPkl::create([
    //             'siswa_id' => $pengajuan->user_id,
    //             'iduka_id' => $request->iduka_id,
    //             'status' => 'proses',
    //         ]);



    //     return response()->json(['message' => 'Pengajuan berhasil dikirim ke IDUKA.']);
    // }

    public function prosesPengajuan($id, Request $request)
    {
        // Validasi iduka_id
        $request->validate([
            'iduka_id' => 'required|exists:idukas,id',
        ]);

        // Ambil data cetak_usulan berdasarkan ID
        $cetak = CetakUsulan::findOrFail($id);

        // Cek duplikat: pastikan siswa + iduka belum pernah di-push ke pengajuan_pkl
        $duplikat = PengajuanPkl::where('siswa_id', $cetak->data_pribadi_id)
            ->where('iduka_id', $request->iduka_id)
            ->exists();

        if ($duplikat) {
            return redirect()->back()->with('info', 'Data sudah dikirim sebelumnya.');
        }

        // Simpan ke tabel pengajuan_pkl
        PengajuanPkl::create([
            'siswa_id' => $cetak->siswa_id, // pastikan ini sesuai dengan struktur
            'iduka_id' => $request->iduka_id,
            'status' => 'proses', // default status ketika baru dibuat
        ]);

        // Update kolom dikirim di cetak_usulans
        $cetak->update([
            'dikirim' => 'sudah',
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim.');
    }







    public function diterima($id, Request $request)
{
    $usulan = UsulanIduka::findOrFail($id);

    // Buat akun user untuk IDUKA
    $user = User::create([
        'name' => $usulan->nama,
        'nip' => $usulan->email,
        'password' => $usulan->password, // sudah hash
        'role' => 'iduka',
    ]);

    // Buat data IDUKA
    $iduka = Iduka::create([
        'user_id' => $user->id,
        'nama' => $usulan->nama,
        'nama_pimpinan' => $usulan->nama_pimpinan,
        'nip_pimpinan' => $usulan->nip_pimpinan,
        'jabatan' => $usulan->jabatan,
        'alamat' => $usulan->alamat,
        'kode_pos' => $usulan->kode_pos,
        'telepon' => $usulan->telepon,
        'email' => $usulan->email,
        'bidang_industri' => $usulan->bidang_industri,
        'kerjasama' => $usulan->kerjasama,
        'password' => $usulan->password,
        'kuota_pkl' => $usulan->kuota_pkl ?? 0,
    ]);

    // Update relasi
    $user->update(['iduka_id' => $iduka->id]);
    $usulan->update(['status' => 'diterima', 'iduka_id' => $iduka->id]);

    // Balikin JSON (Bukan redirect)
    return response()->json([
        'success' => true,
        'message' => 'Usulan IDUKA diterima dan akun pengguna berhasil dibuat.'
    ]);
}




    public function ditolak($id)
    {
        $usulan = UsulanIduka::findOrFail($id);
        $usulan->update(['status' => 'ditolak']);

        return response()->json([
            'success' => true,
            'message' => 'Usulan IDUKA diterima dan akun pengguna berhasil dibuat.'
        ]);    }

        public function diterimaUsulan(Request $request, $id)
        {
            $request->validate(['status' => 'required|in:diterima,ditolak']);
        
            $usulan = PengajuanUsulan::findOrFail($id);
            $usulan->update(['status' => $request->status]);
        
            $msg = $request->status === 'diterima' ? 'Pengajuan PKL diterima.' : 'Pengajuan PKL ditolak.';
            $type = $request->status === 'diterima' ? 'success' : 'error';
        
            // Balikin JSON, bukan redirect
            return response()->json([
                'success' => true,
                'type' => $type,
                'message' => $msg,
            ]);
        }
        

    public function historyDiterima()
    {
        $kaprog = DB::table('gurus')->where('user_id', Auth::id())->first();
        if (!$kaprog) {
            return redirect()->back()->with('error', 'Data Kaprog tidak ditemukan.');
        }

        $usulanDiterima = UsulanIduka::with(['user.dataPribadi.kelas'])
            ->where('status', 'diterima')
            ->where('konke_id', $kaprog->konke_id)
            ->get();

        $usulanDiterimaPkl = PengajuanUsulan::with(['user.dataPribadi.kelas', 'iduka'])
            ->where('status', 'diterima')
            ->where('konke_id', $kaprog->konke_id)
            ->get();

        return view('kaprog.review.historyditerima', compact('usulanDiterima', 'usulanDiterimaPkl'));
    }

    public function historyDitolak()

    {
        $kaprog = DB::table('gurus')->where('user_id', Auth::id())->first();
        if (!$kaprog) {
            return redirect()->back()->with('error', 'Data Kaprog tidak ditemukan.');
        }

        $usulanDitolak = UsulanIduka::with(['user.dataPribadi.kelas'])
            ->where('status', 'ditolak')
            ->where('konke_id', $kaprog->konke_id)
            ->get();

        $usulanDitolakPkl = PengajuanUsulan::with(['user.dataPribadi.kelas', 'iduka'])
            ->where('status', 'ditolak')
            ->whereHas('user', function ($query) use ($kaprog) {
                $query->where('konke_id', $kaprog->konke_id);
            })
            ->get();

        return view('kaprog.review.historyditolak', compact('usulanDitolak', 'usulanDitolakPkl'));
    }


    // public function showDetailUsulan($id)
    // {
    //     $usulan = UsulanIduka::with('user.dataPribadi.kelas', 'user.dataPribadi.konkes')
    //                 ->findOrFail($id);

    //     return view('kaprog.review.detailusulan', compact('usulan'));
    // }




    public function showDetailPengajuanIduka($iduka_id)
    {
        $iduka = Iduka::findOrFail($iduka_id);
        $pengajuans = PengajuanUsulan::where('iduka_id', $iduka_id)
            ->where('status', 'proses') // hanya yang masih dalam proses
            ->with(['user.dataPribadi.kelas']) // eager load user, data pribadi, dan kelas
            ->get();




        return view('kaprog.review.detailpengajuaniduka', compact('iduka', 'pengajuans'));
    }

    //fungsi mengirim ke tabel pengajuan jika siswa sudah mengirim surat
    public function updateSuratIzin(Request $request, $id): JsonResponse
    {
        Log::info('Update Surat Izin', [
            'request' => $request->all(),
            'usulan_id' => $id,
            'tipe' => $request->input('tipe'),
        ]);

        $tipe = $request->input('tipe');

        if ($tipe === 'usulan') {
            $usulan = UsulanIduka::with('user')->find($id);
            if (!$usulan) {
                return response()->json(['success' => false, 'message' => 'Data usulan tidak ditemukan.']);
            }

            if ($usulan->surat_izin == 'belum') {
                $usulan->update(['surat_izin' => 'sudah']);

                CetakUsulan::create([
                    'siswa_id' => $usulan->user_id,
                    'iduka_id' => $usulan->iduka_id,
                    'status' => 'proses',
                ]);

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Surat izin sudah diubah sebelumnya.']);
            }
        }

        if ($tipe === 'pkl') {
            $usulan = PengajuanUsulan::with('user')->find($id);
            if (!$usulan) {
                return response()->json(['success' => false, 'message' => 'Data PKL tidak ditemukan.']);
            }

            if ($usulan->surat_izin == 'belum') {
                $usulan->update(['surat_izin' => 'sudah']);

                CetakUsulan::create([
                    'siswa_id' => $usulan->user_id,
                    'iduka_id' => $usulan->iduka_id,
                    'status' => 'proses',
                ]);

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Surat izin PKL sudah diperbarui sebelumnya.']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Tipe permintaan tidak valid.']);
    }

    //mengirim ke iduka
    public function reviewPengajuan()
    {
        $pengajuanUsulans = CetakUsulan::with(['dataPribadi.kelas', 'iduka'])
            ->where('dikirim', 'belum')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('iduka_id');

        return view('kaprog.review.reviewpengajuan', compact('pengajuanUsulans'));
    }

    public function detailUsulanPkl($iduka_id)
    {
        $iduka = Iduka::findOrFail($iduka_id);

        $pengajuans = CetakUsulan::with(['dataPribadi.kelas'])
            ->where('iduka_id', $iduka_id)
            ->where('dikirim', 'belum') // Atau status yang kamu inginkan
            ->get();

        return view('kaprog.review.reviewdetail', compact('iduka', 'pengajuans'));
    }




    public function detailusulan($iduka_id)
    {
        $pengajuanUsulans = PengajuanUsulan::with(['dataPribadi.kelas'])
            ->where('iduka_id', $iduka_id)
            ->where('status', 'proses')
            ->get();

        return view('kaprog.review.detailusulan', compact('pengajuanUsulans'));
    }

    public function kirimSemua($iduka_id)
    {
        // Ambil semua pengajuan untuk IDUKA tersebut yang statusnya sudah 'sudah'
        $cetak = CetakUsulan::where('iduka_id', $iduka_id)
            ->where('status', 'sudah')
            ->get();

        $jumlahTerkirim = 0;

        foreach ($cetak as $pengajuan) {

            $siswaId = $pengajuan->siswa_id;


            // Cek apakah sudah ada di pengajuan_pkl
            $sudahAda = PengajuanPkl::where('siswa_id', $siswaId)
                ->where('iduka_id', $iduka_id)
                ->exists();

            if (!$sudahAda) {
                // Tambahkan ke tabel pengajuan_pkl
                PengajuanPkl::create([
                    'siswa_id' => $siswaId,
                    'iduka_id' => $iduka_id,
                    'status' => 'proses',
                ]);
                // Update status dikirim di cetak_usulans menjadi 'sudah'
                $pengajuan->update([
                    'dikirim' => 'sudah'
                ]);
                $jumlahTerkirim++;
            }
        }

        if ($jumlahTerkirim > 0) {
            return redirect()->back()->with('success', "$jumlahTerkirim pengajuan berhasil dikirim.");
        } else {
            return redirect()->back()->with('info', "Semua pengajuan sudah pernah dikirim.");
        }
    }

    public function historiPengajuan()
    {
        // Ambil semua data pengajuan yang sudah diproses (status bukan 'proses')
        $historiPengajuan = PengajuanPkl::with('iduka', 'siswa')
            ->where('status', 'diterima')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy('iduka_id');

        return view('kaprog.review.histori', compact('historiPengajuan'));
    }
}
