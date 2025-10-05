<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JournalController extends Controller
{
    public function index()
{
    $user = Auth::user();

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

    // PERUBAHAN: Split berdasarkan status baru
    // Active journals = yang belum disetujui atau ditolak
    $activeJurnals = $jurnals->filter(function ($jurnal) {
        return $jurnal->status === 'pending' || $jurnal->status === 'rejected';
    });

    // History journals = yang sudah disetujui
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

    // Ambil user yang sedang login
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
        // Handle checkbox dengan benar
        'is_pengetahuan_baru' => $request->has('is_pengetahuan_baru') ? 1 : 0,
        'is_dalam_mapel' => $request->has('is_dalam_mapel') ? 1 : 0,
    ];

    // Simpan gambar ke public/uploads/jurnals
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/jurnals'), $fileName);
        $data['foto'] = 'uploads/jurnals/' . $fileName;
    }

    Jurnal::create($data);

    return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil ditambahkan dan menunggu persetujuan.');
}

public function update(Request $request, $id)
{
    try {
        $jurnal = Jurnal::findOrFail($id);

        // Authorization
        $user = Auth::user();
        if ($jurnal->user_id !== $user->id && $jurnal->nis !== $user->nip) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'error' => 'Unauthorized access'], 403);
            }
            abort(403, 'Unauthorized access');
        }

        $validator = Validator::make($request->all(), [
            'tgl' => 'required|date',
            'uraian' => 'required|string|max:1000',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_pengetahuan_baru' => 'nullable',
            'is_dalam_mapel' => 'nullable',
        ]);

        if ($validator->fails()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Data yang dimasukkan tidak valid'
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'tgl' => $request->tgl,
            'uraian' => $request->uraian,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            // Handle checkbox dengan benar
            'is_pengetahuan_baru' => $request->has('is_pengetahuan_baru') ? 1 : 0,
            'is_dalam_mapel' => $request->has('is_dalam_mapel') ? 1 : 0,
        ];

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

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jurnal berhasil diperbarui.',
                'data' => $jurnal
            ]);
        }

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diperbarui.');

    } catch (\Exception $e) {
        Log::error('Error updating journal: ' . $e->getMessage());

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate jurnal: ' . $e->getMessage()
            ], 500);
        }

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

        // Authorization
        $user = Auth::user();
        if ($jurnal->user_id !== $user->id && $jurnal->nis !== $user->nip) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }
            abort(403, 'Unauthorized access');
        }

        // Return HTML content untuk modal
        if (request()->ajax() || request()->wantsJson()) {
            try {
                $html = view('siswa.jurnal.partials.edit', compact('jurnal'))->render();
                return response($html, 200);
            } catch (\Exception $e) {
                $html = '
                <div class="row">
                    <div class="col-md-6">
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Tanggal</label>
                            <input type="date" class="form-control" name="tgl" value="' . $jurnal->tgl . '" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Foto Kegiatan</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                            ' . ($jurnal->foto ? '<small class="text-muted">Foto saat ini: <a href="' . $jurnal->foto . '" target="_blank">Lihat foto</a></small>' : '') . '
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Jam Mulai</label>
                            <input type="time" class="form-control" name="jam_mulai" value="' . $jurnal->jam_mulai . '" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Jam Selesai</label>
                            <input type="time" class="form-control" name="jam_selesai" value="' . $jurnal->jam_selesai . '" required>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Uraian Kegiatan</label>
                    <textarea class="form-control" name="uraian" rows="5" required>' . htmlspecialchars($jurnal->uraian) . '</textarea>
                </div>

                <div class="form-check" style="margin-bottom: 10px;">
                    <input type="checkbox" class="form-check-input" name="is_pengetahuan_baru" id="is_pengetahuan_baru" value="1" ' . ($jurnal->is_pengetahuan_baru ? 'checked' : '') . '>
                    <label class="form-check-label" for="is_pengetahuan_baru">
                        Termasuk pengetahuan baru
                    </label>
                </div>

                <div class="form-check" style="margin-bottom: 20px;">
                    <input type="checkbox" class="form-check-input" name="is_dalam_mapel" id="is_dalam_mapel" value="1" ' . ($jurnal->is_dalam_mapel ? 'checked' : '') . '>
                    <label class="form-check-label" for="is_dalam_mapel">
                        Kegiatan ada dalam mapel sekolah
                    </label>
                </div>
                ';
                return response($html, 200);
            }
        }

        return view('siswa.jurnal.edit', compact('jurnal'));
    }

    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);

        // Authorization
        $user = Auth::user();
        if ($jurnal->user_id !== $user->id && $jurnal->nis !== $user->nip) {
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
