<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalApprovalController extends Controller
{
    // Tampilkan jurnal yang perlu disetujui oleh IDUKA
    public function indexIduka()
{
    $jurnals = Journal::with('user')
        ->whereHas('user') // Hanya ambil jurnal yang memiliki user
        ->where(function($query) {
            $query->where('status', 'pending')
                  ->orWhere('status', 'approved_pembimbing');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('iduka.konfir_jurnal.index', compact('jurnals'));
}
    // Tampilkan jurnal yang perlu disetujui oleh Pembimbing
    public function indexPembimbing()
    {
        $jurnals = Journal::where('status', 'pending')
            ->orWhere('status', 'approved_iduka')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('guru.konfir_jurnal.index', compact('jurnals'));
    }

    // Proses persetujuan oleh IDUKA
    public function approveByIduka($id)
    {
        $journal = Journal::findOrFail($id);

        if ($journal->status === 'pending') {
            $journal->status = 'approved_iduka';
        } elseif ($journal->status === 'approved_pembimbing') {
            $journal->status = 'approved'; // Kedua pihak sudah menyetujui
        }

        $journal->approved_iduka_at = now();
        $journal->save();

        return redirect()->back()->with('success', 'Jurnal berhasil disetujui.');
    }

    // Proses persetujuan oleh Pembimbing
    public function approveByPembimbing($id)
    {
        $journal = Journal::findOrFail($id);

        if ($journal->status === 'pending') {
            $journal->status = 'approved_pembimbing';
        } elseif ($journal->status === 'approved_iduka') {
            $journal->status = 'approved'; // Kedua pihak sudah menyetujui
        }

        $journal->approved_pembimbing_at = now();
        $journal->save();

        return redirect()->back()->with('success', 'Jurnal berhasil disetujui.');
    }

    // Proses penolakan
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejected_reason' => 'required|string|max:500'
        ]);

        $journal = Journal::findOrFail($id);
        $journal->status = 'rejected';
        $journal->rejected_reason = $request->rejected_reason;
        $journal->save();

        return redirect()->back()->with('success', 'Jurnal ditolak.');
    }

    // Detail jurnal untuk persetujuan
    public function showForApproval($id)
    {
        $journal = Journal::findOrFail($id);
        return view('approval.show', compact('journal'));
    }
}
