<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class JournalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Hapus otomatis foto jurnal yang lebih dari 24 jam
        $this->hapusFotoLama();

        // Get all journals for both active and history
        $jurnalsQuery = Jurnal::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('nis', $user->nip);
        })
            ->with([
                'user.idukaDiterima',
                'user.pembimbing'
            ])
            ->orderBy('tgl', 'desc')
            ->orderBy('jam_mulai', 'desc');

        // Get all journals
        $jurnals = $jurnalsQuery->get();

        // Split berdasarkan status
        $activeJurnals = $jurnals->filter(function ($jurnal) {
            return $jurnal->status === 'pending' || $jurnal->status === 'rejected';
        });

        $historyJurnals = $jurnals->filter(function ($jurnal) {
            return $jurnal->status === 'approved';
        });

        return view('siswa.jurnal.index', compact('activeJurnals', 'historyJurnals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl' => 'required|date',
            'uraian' => 'required|string|max:1000',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_pengetahuan_baru' => 'nullable',
            'is_dalam_mapel' => 'nullable',
        ]);

        $user = Auth::user();

        $data = [
            'tgl' => $validated['tgl'],
            'uraian' => $validated['uraian'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'user_id' => $user->id,
            'nis' => $user->nip,
            'status' => 'pending',
            'validasi_iduka' => 'belum',
            'validasi_pembimbing' => 'belum',
            'iduka_id' => $user->iduka_id,
            'pembimbing_id' => $user->pembimbing_id,
            'is_pengetahuan_baru' => $request->has('is_pengetahuan_baru') ? 1 : 0,
            'is_dalam_mapel' => $request->has('is_dalam_mapel') ? 1 : 0,
        ];

        // Pastikan folder upload tersedia
        $uploadPath = public_path('uploads/jurnals');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Simpan dan kompres gambar
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = $uploadPath . '/' . $fileName;

            // Kompres gambar menjadi sangat kecil (kualitas 30)
            try {
                $image = imagecreatefromstring(file_get_contents($file));
                if ($image !== false) {
                    imagejpeg($image, $destinationPath, 30);
                    imagedestroy($image);
                } else {
                    $file->move($uploadPath, $fileName);
                }
            } catch (\Exception $e) {
                Log::error('Gagal kompres foto: ' . $e->getMessage());
                $file->move($uploadPath, $fileName);
            }

            $data['foto'] = 'uploads/jurnals/' . $fileName;
        }

        Jurnal::create($data);

        // Jalankan hapus otomatis setiap kali menambah jurnal
        $this->hapusFotoLama();

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil ditambahkan dan menunggu persetujuan.');
    }

    public function update(Request $request, $id)
    {
        try {
            $jurnal = Jurnal::findOrFail($id);
            $user = Auth::user();

            if ($jurnal->user_id !== $user->id && $jurnal->nis !== $user->nip) {
                abort(403, 'Unauthorized access');
            }

            $validator = Validator::make($request->all(), [
                'tgl' => 'required|date',
                'uraian' => 'required|string|max:1000',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = [
                'tgl' => $request->tgl,
                'uraian' => $request->uraian,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'is_pengetahuan_baru' => $request->has('is_pengetahuan_baru') ? 1 : 0,
                'is_dalam_mapel' => $request->has('is_dalam_mapel') ? 1 : 0,
            ];

            if ($request->hasFile('foto')) {
                if ($jurnal->foto && file_exists(public_path($jurnal->foto))) {
                    unlink(public_path($jurnal->foto));
                }

                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('uploads/jurnals/' . $fileName);

                try {
                    $image = imagecreatefromstring(file_get_contents($file));
                    if ($image !== false) {
                        imagejpeg($image, $destinationPath, 30);
                        imagedestroy($image);
                    } else {
                        $file->move(public_path('uploads/jurnals'), $fileName);
                    }
                } catch (\Exception $e) {
                    $file->move(public_path('uploads/jurnals'), $fileName);
                }

                $data['foto'] = 'uploads/jurnals/' . $fileName;
            }

            $jurnal->update($data);

            return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating journal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate jurnal.');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Loading journal detail for ID: ' . $id);

            $jurnal = Jurnal::with(['user', 'user.idukaDiterima', 'user.pembimbing'])
                ->findOrFail($id);

            if ($jurnal->user_id !== auth()->id()) {
                Log::warning('Unauthorized journal access attempt: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $html = view('siswa.jurnal.view', compact('jurnal'))->render();

            return response()->json([
                'success' => true,
                'data' => $html
            ]);

        } catch (\Exception $e) {
            Log::error('Error in show journal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat detail jurnal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $user = Auth::user();

        if ($jurnal->user_id !== $user->id && $jurnal->nis !== $user->nip) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }
            abort(403, 'Unauthorized access');
        }

        if (request()->ajax() || request()->wantsJson()) {
            try {
                $html = view('siswa.jurnal.partials.edit', compact('jurnal'))->render();
                return response($html, 200);
            } catch (\Exception $e) {
                $html = '
                <div class="row">
                    <div class="col-md-6">
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight: 600; color: #2d3748;">Tanggal</label>
                            <input type="date" class="form-control" name="tgl" value="' . $jurnal->tgl . '" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight: 600; color: #2d3748;">Foto Kegiatan</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                            ' . ($jurnal->foto ? '<small class="text-muted">Foto saat ini: <a href="' . $jurnal->foto . '" target="_blank">Lihat foto</a></small>' : '') . '
                        </div>
                    </div>
                </div>';
                return response($html, 200);
            }
        }

        return view('siswa.jurnal.edit', compact('jurnal'));
    }

    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $user = Auth::user();

        if ($jurnal->user_id !== $user->id && $jurnal->nis !== $user->nip) {
            abort(403, 'Unauthorized access');
        }

        if ($jurnal->foto && file_exists(public_path($jurnal->foto))) {
            unlink(public_path($jurnal->foto));
        }

        $jurnal->delete();

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil dihapus.');
    }

    // ======================
    // AUTO DELETE FOTO 24 JAM
    // ======================
    private function hapusFotoLama()
    {
        $path = public_path('uploads/jurnals');
        if (!file_exists($path)) {
            return;
        }

        $files = glob($path . '/*');
        foreach ($files as $file) {
            if (is_file($file) && (time() - filemtime($file)) > 86400) { // 24 jam
                @unlink($file);
            }
        }
    }
}
