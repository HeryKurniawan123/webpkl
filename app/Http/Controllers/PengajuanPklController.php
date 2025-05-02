<?php
//anjay
namespace App\Http\Controllers;

use App\Models\CetakUsulan;
use App\Models\Iduka;
use App\Models\PengajuanPkl;
use App\Models\PengajuanUsulan;
use App\Models\UsulanIduka;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengajuanPklController extends Controller
{
    // Siswa mengajukan PKL
    public function ajukan(Request $request, $iduka_id)
    {
        $siswa = auth()->user();

        // Cek apakah siswa sudah pernah diterima di IDUKA manapun
        if (PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'diterima')->exists()) {
            return back()->with('error', 'Anda sudah diterima PKL di IDUKA, tidak dapat mengajukan ulang.');
        }

        // Cek apakah siswa sudah mengajukan ke IDUKA ini sebelumnya
        if (PengajuanPkl::where('siswa_id', $siswa->id)->where('iduka_id', $iduka_id)->exists()) {
            return back()->with('error', 'Anda sudah mengajukan PKL ke IDUKA ini.');
        }

        // Simpan pengajuan baru
        PengajuanPkl::create([
            'siswa_id' => $siswa->id,
            'iduka_id' => $iduka_id,
            'status' => 'proses',
        ]);


        return redirect()->route('siswa.dashboard')->with('success', 'Pengajuan PKL berhasil diajukan.');
    }


    // IDUKA menerima atau menolak pengajuan
    public function verifikasi(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:diterima,ditolak']);

        $pengajuan = PengajuanPkl::findOrFail($id);
        $pengajuan->update(['status' => $request->status]);

        return back()->with('success', 'Pengajuan berhasil diperbarui.');
    }

    // Persuratan melihat semua pengajuan
    public function index()
    {
        $pengajuan = PengajuanPkl::with(['siswa', 'iduka'])->get();
        return view('pengajuan.index', compact('pengajuan'));
    }

    // Download Capaian Pembelajaran (CP)
    public function downloadCp($iduka_id)
    {
        $iduka = Iduka::with('cp')->findOrFail($iduka_id);

        // Asumsikan CP berupa file dalam database
        if ($iduka->cp && file_exists(storage_path('app/' . $iduka->cp->file))) {
            return response()->download(storage_path('app/' . $iduka->cp->file));
        }

        return back()->with('error', 'File CP tidak ditemukan.');
    }

    public function reviewPengajuan()
    {
        $iduka_id = auth()->user()->iduka_id;
        $iduka = Iduka::findOrFail($iduka_id);
        $sisa_kuota = $iduka->kuota_pkl - PengajuanPkl::where('iduka_id', $iduka_id)
            ->where('status', 'diterima')
            ->count();


        // Ambil hanya pengajuan yang statusnya "proses"
        $pengajuans = PengajuanPkl::with(['dataPribadi.user', 'dataPribadi.kelas'])
            ->where('iduka_id', $iduka_id)
            ->where('status', 'proses')
            ->get();


        return view('pengajuan.review', compact('pengajuans', 'iduka', 'sisa_kuota', 'iduka_id'));
    }







    public function showPengajuan($id)
    {
        $pengajuan = PengajuanPkl::with(['dataPribadi.kelas', 'iduka'])->findOrFail($id);
        return view('pengajuan.detail', compact('pengajuan'));
    }


    public function reviewPengajuanDiterima()
    {
        $iduka_id = auth()->user()->iduka_id;

        $pengajuans = PengajuanPkl::with(['dataPribadi.user', 'dataPribadi.kelas'])
            ->where('iduka_id', $iduka_id)
            ->where('status', 'diterima') // Hanya ambil yang diterima
            ->get();

        return view('pengajuan.historyditerima', compact('pengajuans'));
    }

    public function reviewPengajuanDitolak()
    {
        $iduka_id = auth()->user()->iduka_id;

        $pengajuans = PengajuanPkl::with(['dataPribadi.user', 'dataPribadi.kelas'])
            ->where('iduka_id', $iduka_id)
            ->where('status', 'ditolak') // Hanya ambil yang ditolak
            ->get();

        return view('pengajuan.historyditolak', compact('pengajuans'));
    }

    public function terima($id)
    {
        $pengajuan = PengajuanPkl::findOrFail($id);

        // Pastikan hanya memproses jika belum diterima sebelumnya
        if ($pengajuan->status !== 'diterima') {
            $iduka = Iduka::findOrFail($pengajuan->iduka_id);

            // Cek apakah kuota tersedia
            if ($iduka->kuota_pkl > 0) {
                $iduka->decrement('kuota_pkl');
                $pengajuan->update(['status' => 'diterima']);
                // Cek dan update status di pengajuan_usulans atau usulan_idukas
                $updated = false;

                $usulan = \App\Models\PengajuanUsulan::where('user_id', $pengajuan->siswa_id)
                    ->where('iduka_id', $pengajuan->iduka_id)
                    ->first();

                if ($usulan) {
                    $usulan->status = 'diterima';
                    $usulan->save();
                    $updated = true;
                    Log::info('Status usulan_iduka updated', ['id' => $usulan->id, 'status' => $usulan->status]);
                } else {
                    $usulanIduka = \App\Models\UsulanIduka::where('user_id', $pengajuan->siswa_id)
                        ->latest() // Ambil yang terbaru
                        ->first();

                    if ($usulanIduka) {
                        $usulanIduka->status = 'diterima';
                        $usulanIduka->save();
                        $updated = true;

                        Log::info('Status usulan_iduka updated', ['id' => $usulanIduka->id, 'status' => $usulanIduka->status]);
                    }
                }
                return redirect()->route('pengajuan.review')->with('success', 'Pengajuan PKL telah diterima dan kuota dikurangi.');
            } else {
                // Jika kuota kosong, arahkan ke halaman iduka pribadi dengan alert error
                return redirect()->route('iduka.pribadi')->with('error', 'IDUKA belum mengisi kuota PKL.');
            }
        }

        return redirect()->route('pengajuan.review')->with('info', 'Pengajuan sudah diterima sebelumnya.');
    }

    public function tolak($id)
    {
        $pengajuan = PengajuanPkl::findOrFail($id);

        if ($pengajuan->status !== 'ditolak') {
            $pengajuan->update(['status' => 'ditolak']);

            // Cek dan update status di pengajuan_usulans atau usulan_idukas
            $updated = false;

            $usulan = \App\Models\PengajuanUsulan::where('user_id', $pengajuan->siswa_id)
                ->where('iduka_id', $pengajuan->iduka_id)
                ->first();

            if ($usulan) {
                $usulan->status = 'ditolak';
                $usulan->save();
                $updated = true;
            } else {
                $usulanIduka = \App\Models\UsulanIduka::where('user_id', $pengajuan->siswa_id)
                    ->where('iduka_id', $pengajuan->iduka_id)
                    ->first();

                if ($usulanIduka) {
                    $usulanIduka->status = 'ditolak';
                    $usulanIduka->save();
                    $updated = true;
                }
            }

            return redirect()->route('pengajuan.review')->with('success', 'Pengajuan PKL telah ditolak.');
        }

        return redirect()->route('pengajuan.review')->with('info', 'Pengajuan sudah ditolak sebelumnya.');
    }

    public function ajukanPembatalan($id)
    {
        Log::info("Memulai proses pengajuan pembatalan untuk ID: " . $id);
    
        // Coba cari di pengajuan_usulans dulu
        $pengajuan = PengajuanUsulan::find($id);
        $tipe = 'pengajuan';
    
        // Jika tidak ada, cari di usulan_idukas
        if (!$pengajuan) {
            Log::info("Pengajuan tidak ditemukan di pengajuan_usulans, mencari di usulan_idukas.");
            $pengajuan = UsulanIduka::find($id);
            $tipe = 'usulan';
        }
    
        if (!$pengajuan) {
            Log::error("Data pengajuan dengan ID: " . $id . " tidak ditemukan di kedua tabel.");
            return redirect()->back()->with('error', 'Pengajuan tidak ditemukan.');
        }
    
        Log::info("Pengajuan ditemukan: " . json_encode($pengajuan));
    
        // Status pengajuan bisa jadi 'menunggu' dan tetap bisa mengajukan pembatalan
        Log::info('Status pengajuan sebelum validasi: ' . $pengajuan->status);
    
        // Periksa jika statusnya dalam status 'proses' atau 'menunggu'
        if (in_array($pengajuan->status, ['proses', 'menunggu'])) {
            // Update status pengajuan
            $pengajuan->status = 'menunggu';
            if ($pengajuan->save()) {
                Log::info('Status pengajuan berhasil diperbarui menjadi "menunggu".');
            } else {
                Log::error('Gagal memperbarui status pengajuan.');
                return redirect()->back()->with('error', 'Gagal memperbarui status pengajuan.');
            }
    
            // Update status cetak_usulans berdasarkan siswa dan iduka
            $cetak = CetakUsulan::where('siswa_id', $pengajuan->siswa_id)
                                ->where('iduka_id', $pengajuan->iduka_id)
                                ->first();
    
            if ($cetak) {
                Log::info("Data cetak_usulan ditemukan, memperbarui status.");
    
                $cetak->dikirim = 'menunggu';
                if ($cetak->save()) {
                    Log::info('Status cetak_usulans berhasil diperbarui menjadi "menunggu".');
                } else {
                    Log::error('Gagal memperbarui status cetak_usulans.');
                    return redirect()->back()->with('error', 'Gagal memperbarui status cetak_usulans.');
                }
            } else {
                Log::info("Data cetak_usulans tidak ditemukan untuk siswa_id: " . $pengajuan->siswa_id . " dan iduka_id: " . $pengajuan->iduka_id);
            }
    
            return redirect()->back()->with('success', 'Permintaan pembatalan berhasil diajukan.');
        }
    
        // Jika status sudah 'batal', beri tahu pengguna bahwa pengajuan sudah dibatalkan
        if ($pengajuan->status == 'batal') {
            Log::warning("Pengajuan sudah dibatalkan sebelumnya, tidak bisa dibatalkan lagi.");
            return redirect()->back()->with('error', 'Pengajuan ini sudah dibatalkan.');
        }
    
        Log::warning("Pengajuan tidak dapat dibatalkan karena statusnya bukan 'proses' atau 'menunggu'.");
        return redirect()->back()->with('error', 'Pengajuan tidak dapat dibatalkan.');
    }
    
    
    

    public function listPembatalan()
    {
        $pengajuans = PengajuanUsulan::where('status', 'menunggu pembatalan')->with('dataPribadi')->get();
        return view('kaprog.pengajuan.pembatalan', compact('pengajuans'));
    }

    public function setujuiPembatalan($id)
    {
        $pengajuan = PengajuanUsulan::findOrFail($id);
        $pengajuan->status = 'batal';
        $pengajuan->save();

        DB::table('cetak_usulans')->where('pengajuan_id', $id)->update(['kirim' => 'batal']);

        return redirect()->back()->with('success', 'Pengajuan berhasil dibatalkan.');
    }


    public function tolakPembatalan($id)
    {
        $pengajuan = PengajuanUsulan::findOrFail($id);
        $pengajuan->status = 'diterima'; // atau kembalikan ke sebelumnya
        $pengajuan->save();

        DB::table('cetak_usulans')->where('pengajuan_id', $id)->update(['kirim' => 'sudah']);

        return redirect()->back()->with('info', 'Pembatalan ditolak, status dikembalikan.');
    }
}
