<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    public function index()
    {
        $nis = Auth::user()->nis;
        $jurnals = Journal::where('nis', $nis)
            ->orderBy('tgl', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(10);

        return view('siswa.jurnal.index', compact('jurnals'));
    }

    public function create()
    {
        return view('jurnal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl' => 'required|date',
            'uraian' => 'required|string|max:1000',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['tgl', 'uraian', 'jam_mulai', 'jam_selesai']);
        $data['nis'] = Auth::user()->nis; // Gunakan nis, bukan user_id

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/jurnals');
            $data['foto'] = Storage::url($path);
        }

        Journal::create($data);

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function show(Journal $jurnal)
    {
        // Authorization
        if ($jurnal->nis !== Auth::user()->nis) {
            if (request()->ajax() || request()->wantsJson()) {
                return response('<div class="alert alert-danger">Unauthorized access</div>', 403);
            }
            abort(403, 'Unauthorized access');
        }

        // Return partial view untuk modal
        if (request()->ajax() || request()->wantsJson()) {
            return response()->view('siswa.jurnal.partials.view', compact('jurnal'));
        }

        return view('siswa.jurnal.show', compact('jurnal'));
    }

    public function edit(Journal $jurnal)
    {
        // Authorization
        if ($jurnal->nis !== Auth::user()->nis) {
            if (request()->ajax() || request()->wantsJson()) {
                return response('<div class="alert alert-danger">Unauthorized access</div>', 403);
            }
            abort(403, 'Unauthorized access');
        }

        // Return partial view untuk modal
        if (request()->ajax() || request()->wantsJson()) {
            return response()->view('siswa.jurnal.partials.edit', compact('jurnal'));
        }

        return view('siswa.jurnal.edit', compact('jurnal'));
    }

    public function update(Request $request, Journal $jurnal)
    {
        // Authorization
        if ($jurnal->nis !== Auth::user()->nis) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'tgl' => 'required|date',
            'uraian' => 'required|string|max:1000',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['tgl', 'uraian', 'jam_mulai', 'jam_selesai']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($jurnal->foto) {
                $oldPath = str_replace('/storage', 'public', $jurnal->foto);
                Storage::delete($oldPath);
            }

            $path = $request->file('foto')->store('public/jurnals');
            $data['foto'] = Storage::url($path);
        }

        $jurnal->update($data);

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(Journal $jurnal)
    {
        // Authorization
        if ($jurnal->nis !== Auth::user()->nis) {
            abort(403, 'Unauthorized access');
        }

        // Hapus foto jika ada
        if ($jurnal->foto) {
            $path = str_replace('/storage', 'public', $jurnal->foto);
            Storage::delete($path);
        }

        $jurnal->delete();

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil dihapus.');
    }
}
