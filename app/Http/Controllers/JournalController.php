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
                // Jika request AJAX, kembalikan error JSON
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal.',
                        'errors' => $validator->errors()
                    ], 422);
                }
                // Jika bukan, kembalikan dengan error seperti biasa
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

            // PERBAIKAN: Cek apakah request dari AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Jurnal berhasil diperbarui.'
                ]);
            }

            return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating journal: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengupdate jurnal.'
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
        $user = Auth::user();

        if ($jurnal->user_id !== $user->id && $jurnal->nis !== $user->nip) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }
            abort(403, 'Unauthorized access');
        }

        if (request()->ajax() || request()->wantsJson()) {
            try {
                // Render the complete edit form
                $html = view('siswa.jurnal.partials.edit', compact('jurnal'))->render();
                return response($html, 200);
            } catch (\Exception $e) {
                Log::error('Error rendering edit form: ' . $e->getMessage());
                
                // Return a complete form even if there's an error
                $html = '
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-uppercase small text-muted mb-2">
                            <i class="bi bi-calendar3 me-1"></i>Tanggal
                        </label>
                        <input type="date" class="form-control form-control-lg" name="tgl" value="' . $jurnal->tgl . '" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-uppercase small text-muted mb-2">
                            <i class="bi bi-image me-1"></i>Foto Kegiatan
                        </label>
                        <input type="file" class="form-control form-control-lg" name="foto" accept="image/*">';
                
                if ($jurnal->foto) {
                    $html .= '
                    <div class="mt-2 p-2 bg-light rounded">
                        <small class="text-muted d-flex align-items-center">
                            <i class="bi bi-image-fill text-primary me-2"></i>
                            <span>Foto saat ini: </span>
                            <a href="' . asset($jurnal->foto) . '" target="_blank" class="text-primary ms-1 text-decoration-none fw-semibold">
                                <i class="bi bi-eye me-1"></i>Lihat foto
                            </a>
                        </small>
                    </div>';
                } else {
                    $html .= '
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle me-1"></i>Belum ada foto. Upload foto baru jika diperlukan.
                    </small>';
                }
                
                $html .= '
                        <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF (Max: 2MB)</small>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-uppercase small text-muted mb-2">
                            <i class="bi bi-clock me-1"></i>Jam Mulai
                        </label>
                        <input type="time" class="form-control form-control-lg" name="jam_mulai" value="' . $jurnal->jam_mulai . '" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-uppercase small text-muted mb-2">
                            <i class="bi bi-clock-history me-1"></i>Jam Selesai
                        </label>
                        <input type="time" class="form-control form-control-lg" name="jam_selesai" value="' . $jurnal->jam_selesai . '" required>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label fw-semibold text-uppercase small text-muted mb-2">
                        <i class="bi bi-file-text me-1"></i>Uraian Kegiatan
                    </label>
                    <textarea class="form-control form-control-lg" name="uraian" rows="5" 
                        placeholder="Tuliskan uraian kegiatan yang dilakukan..." required>' . $jurnal->uraian . '</textarea>
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>Maksimal 1000 karakter
                    </small>
                </div>

                <div class="mt-4 p-3 bg-light rounded">
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="is_pengetahuan_baru" 
                            id="edit_is_pengetahuan_baru" value="1" ' . ($jurnal->is_pengetahuan_baru ? 'checked' : '') . '>
                        <label class="form-check-label fw-semibold" for="edit_is_pengetahuan_baru">
                            <i class="bi bi-lightbulb-fill text-warning me-1"></i>
                            Termasuk pengetahuan baru
                        </label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="is_dalam_mapel" 
                            id="edit_is_dalam_mapel" value="1" ' . ($jurnal->is_dalam_mapel ? 'checked' : '') . '>
                        <label class="form-check-label fw-semibold" for="edit_is_dalam_mapel">
                            <i class="bi bi-book-fill text-primary me-1"></i>
                            Kegiatan ada dalam mapel sekolah
                        </label>
                    </div>
                </div>';
                
                if ($jurnal->status === 'rejected') {
                    $html .= '
                <div class="alert alert-danger mt-4 border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-3 me-3"></i>
                        <div>
                            <strong class="d-block mb-1">Jurnal Ditolak</strong>
                            <small>Silakan perbaiki jurnal Anda dan kirim ulang untuk validasi.</small>
                        </div>
                    </div>
                </div>';
                }
                
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