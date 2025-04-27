<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use App\Models\IdukaAtp;
use App\Models\CetakUsulan;
use App\Models\PengajuanPkl;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SuratBalasanHistory;

class PersuratanController extends Controller
{
    public function index()
    {
        return view('persuratan.suratPengajuan.suratPengajuan');
    }
// DETAIL SISWA DI PERSURATAN
    public function show($id)
    {
        $pengajuan = CetakUsulan::with([
            'dataPribadi.kelas',
            'iduka.user.pembimbingpkl', // Mengambil pembimbing lewat user di iduka
            'iduka.konkes',
            'iduka.cp',
            'iduka.atps'
        ])->findOrFail($id);

        return view('persuratan.suratPengajuan.detailSuratPengajuan', compact('pengajuan'));
    }



    public function idukaBaru()
    {
        return view('persuratan.PengajuanIdukaBaru.idukaBaru');
    }

    public function showidukaBaru()
    {
        return view('persuratan.PengajuanIdukaBaru.detailidukaBaru');
    }

    public function downloadPdf($id)
    {
        $pengajuan = CetakUsulan::with(['dataPribadi.kelas', 'iduka.user.pembimbingpkl', 'iduka.konkes', 'iduka.cp', 'iduka.atps'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('persuratan.suratPengajuan.surat-pengajuan', compact('pengajuan'));

        return $pdf->download('Surat_Pengajuan_' . $pengajuan->dataPribadi->nama . '.pdf');
    }

    public function create()
    {
        return view('persuratan.data_pribadi.form');
    }

    public function reviewPengajuan()
    {
        $pengajuanUsulans = CetakUsulan::with(['dataPribadi.kelas', 'iduka'])
            ->where('status', 'proses')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('iduka_id');

        return view('persuratan.review', compact('pengajuanUsulans'));
    }

    public function suratBalasan()
    {
        $pengajuanUsulans = PengajuanPkl::with(['dataPribadi.kelas', 'iduka'])
            ->where('status', 'diterima')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('iduka_id');

        return view('persuratan.suratBalasan.suratbalasan', compact('pengajuanUsulans'));
    }

    public function detailBalasan($iduka_id)
    {
        $iduka = Iduka::findOrFail($iduka_id);

        $pengajuans = CetakUsulan::with(['dataPribadi.kelas'])
            ->where('iduka_id', $iduka_id)
            ->where('status', 'sudah') // Atau status yang kamu inginkan
            ->get();

        return view('persuratan.suratBalasan.detailbalasan', compact('iduka', 'pengajuans'));
    }


//     public function downloadSuratBalasan($id)
// {
//     // Gunakan model CetakUsulan karena sesuai dengan struktur database Anda
//     $pengajuan = CetakUsulan::with(['dataPribadi', 'iduka'])
//         ->findOrFail($id);

//     // Pastikan data pribadi dan iduka tersedia
//     if (!$pengajuan->dataPribadi || !$pengajuan->iduka) {
//         return redirect()->back()->with('error', 'Data siswa atau IDUKA tidak ditemukan');
//     }

//     // Load view surat balasan
//     $pdf = Pdf::loadView('persuratan.suratBalasan.suratbalasan-pdf', [
//         'pengajuan' => $pengajuan,
//         'siswa' => $pengajuan->dataPribadi,
//         'iduka' => $pengajuan->iduka
//     ]);

//     // Download PDF dengan nama file yang sesuai
//     return $pdf->download('Surat_Balasan_' . $pengajuan->dataPribadi->name . '.pdf');
// }
    public function detailUsulan($iduka_id)
    {
        $pengajuanUsulans = CetakUsulan::with(['dataPribadi.kelas', 'iduka'])
            ->where('iduka_id', $iduka_id)
            ->where('status', 'proses')
            ->get();
    
        return view('persuratan.detail', compact('pengajuanUsulans', 'iduka_id'));
    }
    


    public function prosesPengajuan($id)
    {
        $pengajuan = CetakUsulan::findOrFail($id);
        $pengajuan->status = 'sudah';
        $pengajuan->save();

        return response()->json(['success' => true, 'message' => 'Data berhasil di kirim ke Kaprog.']);
    }

    //mengubah semua status siswa jadi sudah
    public function kirimSemua($iduka_id)
    {
        $pengajuanList = CetakUsulan::where('iduka_id', $iduka_id)->where('status', 'proses')->get();

        foreach ($pengajuanList as $pengajuan) {
            $pengajuan->status = 'sudah';
            $pengajuan->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil di kirim ke Kaprog.'
        ]);
    }

    public function suratPengantar()
    {
        return view('surat_pengantar.surat_pengantarPDF');
    }

    public function historykirim()
    {
        $dataDikirim = CetakUsulan::with('iduka', 'siswa')
            ->where('status', 'sudah')
            ->orderByDesc('created_at') // Urut berdasarkan tanggal terbaru
            ->get();
    
        return view('persuratan.historykirim', compact('dataDikirim'));
    }
    

    public function downloadKelompokPdf($iduka_id)
{
    // Ambil semua pengajuan berdasarkan IDUKA
    $pengajuans = CetakUsulan::with(['dataPribadi.kelas', 'iduka.konkes'])
        ->where('iduka_id', $iduka_id)
        ->where('status', 'proses')
        ->get();

    if ($pengajuans->isEmpty()) {
        return back()->with('error', 'Tidak ada data pengajuan untuk IDUKA ini.');
    }

    $iduka = $pengajuans->first()->iduka;

    $pdf = Pdf::loadView('persuratan.suratPengajuan.surat-pengajuan-kelompok', compact('pengajuans', 'iduka'));

    return $pdf->download('Surat_Pengajuan_Kelompok_' . $iduka->nama . '.pdf');
}

public function downloadSuratBalasan($id)
{
    $pengajuan = CetakUsulan::with(['dataPribadi', 'iduka'])
        ->findOrFail($id);

    if (!$pengajuan->dataPribadi || !$pengajuan->iduka) {
        return redirect()->back()->with('error', 'Data siswa atau IDUKA tidak ditemukan');
    }

    // Cek apakah sudah ada histori download
    $historyExists = SuratBalasanHistory::where('cetak_usulan_id', $pengajuan->id)
        ->where('downloaded_by', auth()->user()->name)
        ->exists();

        if ($historyExists) {
            session()->flash('info', 'Histori download sudah ada.');
        } else {
            SuratBalasanHistory::create([
                'cetak_usulan_id' => $pengajuan->id,
                'downloaded_by' => auth()->user()->name
            ]);
            session()->flash('success', 'Histori download berhasil disimpan.');
        }
        
        

    $pdf = Pdf::loadView('persuratan.suratBalasan.suratbalasan-pdf', [
        'pengajuan' => $pengajuan,
        'siswa' => $pengajuan->dataPribadi,
        'iduka' => $pengajuan->iduka
    ]);

    return $pdf->download('Surat_Balasan_' . $pengajuan->dataPribadi->nama . '.pdf');
}

public function historyBalasan()
{
    $histori = SuratBalasanHistory::with(['cetakUsulan.dataPribadi', 'cetakUsulan.iduka'])
        ->whereHas('cetakUsulan', function($query) {
            $query->where('status', 'sudah');
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function($item) {
            return $item->cetakUsulan->iduka_id;
        });

    return view('persuratan.suratBalasan.history', compact('histori'));
}

public function updateStatusSurat(Request $request)
{
    $request->validate([
        'history_id' => 'required|exists:surat_balasan_histories,id'
    ]);

    $history = SuratBalasanHistory::find($request->history_id);
    $history->status_surat = 'sudah';
    $history->save();

    return response()->json([
        'success' => true,
        'message' => 'Status surat berhasil diubah'
    ]);
}
}
