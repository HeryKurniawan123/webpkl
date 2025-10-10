<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Iduka;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Monitoring::with('iduka');

        if ($request->filled('nama_iduka')) {
            $search = $request->nama_iduka;
            $query->whereHas('iduka', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        $monitoring = $query->orderByDesc('id')->paginate(10);
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
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tgl' => 'required|date',
        ]);

        $data = $request->only(['iduka_id', 'saran', 'perikiraan_siswa_diterima', 'tgl']);

        $guru = \App\Models\Guru::where('user_id', auth()->id())->first();
        if ($guru) {
            $data['guru_id'] = $guru->id;
        }

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/monitoring'), $filename);
                $fotoPaths[] = 'uploads/monitoring/' . $filename;
            }
        }

        // Simpan sebagai JSON
        $data['foto'] = json_encode($fotoPaths);

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

    public function update(Request $request, $id)
    {
        $monitoring = Monitoring::findOrFail($id);

        $request->validate([
            'iduka_id' => 'required|exists:idukas,id',
            'saran' => 'nullable|string',
            'perikiraan_siswa_diterima' => 'nullable|integer|min:0',
            'foto.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // === HAPUS FOTO LAMA JIKA ADA ===
        if ($monitoring->foto) {
            $fotoLama = json_decode($monitoring->foto, true);
            foreach ($fotoLama as $fotoPath) {
                $fullPath = public_path($fotoPath);
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
        }

        $fotoBaru = [];
        // === SIMPAN FOTO BARU ===
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/monitoring'), $namaFile);
                $fotoBaru[] = 'uploads/monitoring/' . $namaFile;
            }
        }

        // Simpan data baru ke database
        $monitoring->update([
            'iduka_id' => $request->iduka_id,
            'saran' => $request->saran,
            'perikiraan_siswa_diterima' => $request->perikiraan_siswa_diterima,
            'foto' => json_encode($fotoBaru),
        ]);

        return redirect()->route('monitoring.index')->with('success', 'Data monitoring berhasil diperbarui.');
    }



    public function destroy(Monitoring $monitoring)
    {
        $fotoPaths = json_decode($monitoring->foto ?? '[]', true);
        foreach ($fotoPaths as $path) {
            if (File::exists(public_path($path))) {
                File::delete(public_path($path));
            }
        }

        $monitoring->delete();

        return redirect()->route('monitoring.index')->with('success', 'Data monitoring berhasil dihapus.');
    }
}
