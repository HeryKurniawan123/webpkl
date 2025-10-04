<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Iduka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    /**
     * Display a listing of monitoring data.
     */
    public function index(Request $request)
    {
        $query = Monitoring::with('iduka');

        // Filter berdasarkan nama IDUKA
        if ($request->filled('nama_iduka')) {
            $search = $request->nama_iduka;
            $query->whereHas('iduka', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        $monitoring = $query->orderByDesc('id')->paginate(10);

        // Hitung statistik
        $totalMonitoring = Monitoring::count();
        $totalIduka = Iduka::count();
        $totalIdukaWithMonitoring = Monitoring::distinct('iduka_id')->count();
        $totalIdukaWithoutMonitoring = $totalIduka - $totalIdukaWithMonitoring;

        // Perkiraan total siswa yang akan diterima
        $totalPerkiraanSiswa = Monitoring::sum('perikiraan_siswa_diterima');

        return view('monitoring.index', compact(
            'monitoring',
            'totalMonitoring',
            'totalIduka',
            'totalIdukaWithMonitoring',
            'totalIdukaWithoutMonitoring',
            'totalPerkiraanSiswa'
        ));
    }

    /**
     * Show the form for creating a new monitoring record.
     */
    public function create()
    {
        $idukas = Iduka::orderBy('nama')->get();
        return view('monitoring.create', compact('idukas'));
    }

    /**
     * Store a newly created monitoring record in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'iduka_id' => 'required|exists:idukas,id',
            'saran' => 'nullable|string',
            'perikiraan_siswa_diterima' => 'nullable|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tgl' => 'required'
        ]);

        $data = $request->only(['iduka_id', 'saran', 'perikiraan_siswa_diterima']);

        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/monitoring', $filename);
            $data['foto'] = $filename;
            $data['tgl'] = $request->tgl;
        }

        Monitoring::create($data);

        return redirect()->route('monitoring.index')
            ->with('success', 'Data monitoring berhasil ditambahkan.');
    }

    /**
     * Display the specified monitoring record.
     */
    public function show(Monitoring $monitoring)
    {
        $monitoring->load('iduka');
        return view('monitoring.show', compact('monitoring'));
    }

    /**
     * Show the form for editing the specified monitoring record.
     */
    public function edit(Monitoring $monitoring)
    {
        $idukas = Iduka::orderBy('nama')->get();
        return view('monitoring.edit', compact('monitoring', 'idukas'));
    }

    /**
     * Update the specified monitoring record in storage.
     */
    public function update(Request $request, Monitoring $monitoring)
    {
        $request->validate([
            'iduka_id' => 'required|exists:idukas,id',
            'saran' => 'nullable|string',
            'perikiraan_siswa_diterima' => 'nullable|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tgl' => 'required'
        ]);

        $data = $request->only(['iduka_id', 'saran', 'perikiraan_siswa_diterima' , 'tgl']);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($monitoring->foto && Storage::exists('public/monitoring/' . $monitoring->foto)) {
                Storage::delete('public/monitoring/' . $monitoring->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/monitoring', $filename);
            $data['foto'] = $filename;
        }

        $monitoring->update($data);

        return redirect()->route('monitoring.index')
            ->with('success', 'Data monitoring berhasil diperbarui.');
    }

    /**
     * Remove the specified monitoring record from storage.
     */
    public function destroy(Monitoring $monitoring)
    {
        // Delete photo if exists
        if ($monitoring->foto && Storage::exists('public/monitoring/' . $monitoring->foto)) {
            Storage::delete('public/monitoring/' . $monitoring->foto);
        }

        $monitoring->delete();

        return redirect()->route('monitoring.index')
            ->with('success', 'Data monitoring berhasil dihapus.');
    }


}
