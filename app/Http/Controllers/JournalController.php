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
        $data['nis'] = Auth::user()->nis;
        $data['status'] = 'pending'; // Status awal pending

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/jurnals');
            $data['foto'] = Storage::url($path);
        }

        Journal::create($data);

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil ditambahkan dan menunggu persetujuan.');
    }

    public function show($id)
    {
        // Find jurnal by ID
        $jurnal = Journal::findOrFail($id);

        // Authorization
        if ($jurnal->nis !== Auth::user()->nis) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }
            abort(403, 'Unauthorized access');
        }

        // Return HTML content untuk modal
        if (request()->ajax() || request()->wantsJson()) {
            try {
                $html = view('siswa.jurnal.partials.view', compact('jurnal'))->render();
                return response($html, 200);
            } catch (\Exception $e) {
                // Jika view partial tidak ada, buat HTML langsung
                $formattedDate = \Carbon\Carbon::parse($jurnal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY');

                $html = '
                <div class="row">
                    <div class="col-md-6">
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Tanggal</label>
                            <div style="color: #4a5568;">' . $formattedDate . '</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Waktu</label>
                            <div style="color: #4a5568;">' . $jurnal->jam_mulai . ' - ' . $jurnal->jam_selesai . '</div>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Uraian Kegiatan</label>
                    <div style="color: #4a5568; line-height: 1.6; white-space: pre-wrap;">' . $jurnal->uraian . '</div>
                </div>';

                if ($jurnal->foto) {
                    $html .= '
                    <div style="margin-bottom: 20px;">
                        <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Foto Kegiatan</label>
                        <img src="' . $jurnal->foto . '" alt="Foto Kegiatan" style="max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>';
                }

                $html .= '
                <div class="row">
                    <div class="col-md-6">
                        <div style="margin-bottom: 15px;">
                            <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Status Pembimbing</label>';

                if ($jurnal->validasi_pembimbing == 'sudah') {
                    $html .= '<span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">✅ Disetujui</span>';
                } else {
                    $html .= '<span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">⏳ Menunggu Persetujuan</span>';
                }

                $html .= '</div>
                    </div>
                    <div class="col-md-6">
                        <div style="margin-bottom: 15px;">
                            <label style="font-weight: 600; color: #2d3748; display: block; margin-bottom: 8px;">Status IDUKA</label>';

                if ($jurnal->validasi_iduka == 'sudah') {
                    $html .= '<span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">✅ Disetujui</span>';
                } else {
                    $html .= '<span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">⏳ Menunggu Persetujuan</span>';
                }

                $html .= '</div>
                    </div>
                </div>';

                return response($html, 200);
            }
        }

        return view('siswa.jurnal.show', compact('jurnal'));
    }

    public function edit($id)
    {
        // Find jurnal by ID
        $jurnal = Journal::findOrFail($id);

        // Authorization
        if ($jurnal->nis !== Auth::user()->nis) {
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
                // Jika view partial tidak ada, buat HTML langsung
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
                </div>';

                return response($html, 200);
            }
        }

        return view('siswa.jurnal.edit', compact('jurnal'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Find jurnal by ID
            $jurnal = Journal::findOrFail($id);

            // Authorization
            if ($jurnal->nis !== Auth::user()->nis) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json(['success' => false, 'error' => 'Unauthorized access'], 403);
                }
                abort(403, 'Unauthorized access');
            }

            // Validation
            $validator = \Validator::make($request->all(), [
                'tgl' => 'required|date',
                'uraian' => 'required|string|max:1000',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Jurnal berhasil diperbarui.',
                    'data' => $jurnal
                ]);
            }

            return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diperbarui.');

        } catch (\Exception $e) {
            \Log::error('Error updating journal: ' . $e->getMessage());

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengupdate jurnal: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate jurnal.');
        }
    }

    public function destroy($id)
    {
        // Find jurnal by ID
        $jurnal = Journal::findOrFail($id);

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
