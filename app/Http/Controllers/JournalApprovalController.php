<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalApprovalController extends Controller
{
    // Tampilkan jurnal yang perlu disetujui oleh IDUKA
    public function indexIduka()
    {
        $jurnals = Jurnal::with('user')
            ->whereHas('user')
            ->where('validasi_iduka', 'belum') // Hanya yang belum divalidasi IDUKA
            ->where('status', '!=', 'rejected') // Tidak termasuk yang sudah ditolak
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('iduka.konfir_jurnal.index', compact('jurnals'));
    }

    // Tampilkan riwayat persetujuan oleh IDUKA
    public function riwayatIduka()
    {
        $jurnals = Jurnal::with('user')
            ->whereHas('user')
            ->where(function($query) {
                $query->where('validasi_iduka', 'sudah')
                      ->orWhere('status', 'rejected');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('iduka.konfir_jurnal.riwayat', compact('jurnals'));
    }

    // Tampilkan jurnal yang perlu disetujui oleh Pembimbing
    public function indexPembimbing()
    {
        $jurnals = Jurnal::with('user')
            ->whereHas('user')
            ->where('validasi_pembimbing', 'belum') // Hanya yang belum divalidasi Pembimbing
            ->where('status', '!=', 'rejected') // Tidak termasuk yang sudah ditolak
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('guru.konfir_jurnal.index', compact('jurnals'));
    }

    // Tampilkan riwayat persetujuan oleh Pembimbing
    public function riwayatPembimbing()
    {
        $jurnals = Jurnal::with('user')
            ->whereHas('user')
            ->where(function($query) {
                $query->where('validasi_pembimbing', 'sudah')
                      ->orWhere('status', 'rejected');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('guru.konfir_jurnal.riwayat', compact('jurnals'));
    }

    // Proses persetujuan oleh IDUKA
    public function approveByIduka($id)
    {
        try {
            DB::beginTransaction();
            
            $journal = Jurnal::findOrFail($id);

            // Update validasi IDUKA
            $journal->validasi_iduka = 'sudah';
            
            // Update status berdasarkan kondisi pembimbing
            if ($journal->validasi_pembimbing === 'sudah') {
                $journal->status = 'approved'; // Kedua pihak sudah menyetujui
            } else {
                $journal->status = 'approved_iduka';
            }

            $journal->save();
            
            DB::commit();

            return redirect()->route('approval.iduka.index')->with('success', 'Jurnal berhasil disetujui oleh IDUKA.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui jurnal: ' . $e->getMessage());
        }
    }

    // Proses persetujuan oleh Pembimbing
    public function approveByPembimbing($id)
    {
        try {
            DB::beginTransaction();
            
            $journal = Jurnal::findOrFail($id);

            // Update validasi Pembimbing
            $journal->validasi_pembimbing = 'sudah';
            
            // Update status berdasarkan kondisi IDUKA
            if ($journal->validasi_iduka === 'sudah') {
                $journal->status = 'approved'; // Kedua pihak sudah menyetujui
            } else {
                $journal->status = 'approved_pembimbing';
            }

            $journal->save();
            
            DB::commit();

            return redirect()->route('approval.pembimbing.index')->with('success', 'Jurnal berhasil disetujui oleh Pembimbing.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui jurnal: ' . $e->getMessage());
        }
    }

    // Proses penolakan
    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'rejected_reason' => 'required|string|max:500'
            ]);

            DB::beginTransaction();
            
            $journal = Jurnal::findOrFail($id);
            $journal->status = 'rejected';
            $journal->rejected_reason = $request->rejected_reason;
            $journal->rejected_at = now();
            
            // Tentukan siapa yang menolak
            if (auth()->user()->role === 'iduka') {
                $journal->validasi_iduka = 'ditolak';
            } else if (auth()->user()->role === 'pembimbing') {
                $journal->validasi_pembimbing = 'ditolak';
            }
            
            $journal->save();
            
            DB::commit();

            return redirect()->back()->with('success', 'Jurnal berhasil ditolak.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak jurnal: ' . $e->getMessage());
        }
    }

    // Detail jurnal untuk persetujuan (modal)
    public function showDetail($id)
    {
        $journal = Jurnal::with('user')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => view('partials.jurnal_detail', compact('journal'))->render()
        ]);
    }
}