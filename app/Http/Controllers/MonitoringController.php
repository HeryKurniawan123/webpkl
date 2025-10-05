<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Iduka;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{

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

        // === Statistik lama (biarkan tetap ada) ===
        $totalMonitoring = Monitoring::count();
        $totalIduka = Iduka::count();
        $totalIdukaWithMonitoring = Monitoring::distinct('iduka_id')->count();
        $totalIdukaWithoutMonitoring = $totalIduka - $totalIdukaWithMonitoring;
        $totalPerkiraanSiswa = Monitoring::sum('perikiraan_siswa_diterima');

        $guruBelumMonitoringData = User::whereIn('role', ['guru', 'kaprog'])
            ->whereDoesntHave('monitoring')
            ->get();

        $guruBelumMonitoring = $guruBelumMonitoringData->count();


        return view('monitoring.index', compact(
            'monitoring',
            'totalMonitoring',
            'totalIduka',
            'totalIdukaWithMonitoring',
            'totalIdukaWithoutMonitoring',
            'totalPerkiraanSiswa',
            'guruBelumMonitoring',
            'guruBelumMonitoringData'
        ));

    }



    public function create()
    {
        $idukas = Iduka::orderBy('nama')->get();
        return view('monitoring.create', compact('idukas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'iduka_id' => 'required|exists:idukas,id',
            'saran' => 'nullable|string',
            'perikiraan_siswa_diterima' => 'nullable|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tgl' => 'required|date',
        ]);

        $data = $request->only(['iduka_id', 'saran', 'perikiraan_siswa_diterima', 'tgl']);

        // Ambil guru_id dari user login
        $guru = \App\Models\Guru::where('user_id', auth()->id())->first();
        if ($guru) {
            $data['guru_id'] = $guru->id;
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/monitoring', $filename);
            $data['foto'] = $filename;
        }

        Monitoring::create($data);

        return redirect()->route('monitoring.index')->with('success', 'Data monitoring berhasil ditambahkan.');
    }

    public function show(Monitoring $monitoring)
    {
        $monitoring->load(['iduka', 'user']);
        return view('monitoring.show', compact('monitoring'));
    }

    public function edit(Monitoring $monitoring)
    {
        $idukas = Iduka::orderBy('nama')->get();
        return view('monitoring.edit', compact('monitoring', 'idukas'));
    }

    public function update(Request $request, Monitoring $monitoring)
    {
        $request->validate([
            'iduka_id' => 'required|exists:idukas,id',
            'saran' => 'nullable|string',
            'perikiraan_siswa_diterima' => 'nullable|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tgl' => 'required|date'
        ]);

        $data = $request->only(['iduka_id', 'saran', 'perikiraan_siswa_diterima', 'tgl']);

        if ($request->hasFile('foto')) {
            if ($monitoring->foto && Storage::exists('public/monitoring/' . $monitoring->foto)) {
                Storage::delete('public/monitoring/' . $monitoring->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/monitoring', $filename);
            $data['foto'] = $filename;
        }

        $monitoring->update($data);

        return redirect()->route('monitoring.index')->with('success', 'Data monitoring berhasil diperbarui.');
    }

    public function destroy(Monitoring $monitoring)
    {
        if ($monitoring->foto && Storage::exists('public/monitoring/' . $monitoring->foto)) {
            Storage::delete('public/monitoring/' . $monitoring->foto);
        }

        $monitoring->delete();

        return redirect()->route('monitoring.index')->with('success', 'Data monitoring berhasil dihapus.');
    }
}
