<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\AbsensiPending;
use App\Models\DinasPending;
use App\Models\IzinPending;
use App\Models\Iduka;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $absensiHariIni = null;
        $riwayatAbsensi = collect();
        $canPulang = false;

        // Get today's attendance if exists
        if ($user->idukaDiterima) {
            $absensiHariIni = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            // Get recent attendance history (last 7 days)
            $riwayatAbsensi = Absensi::where('user_id', $user->id)
                ->whereBetween('tanggal', [
                    Carbon::now()->subDays(7),
                    Carbon::today()
                ])
                ->orderBy('tanggal', 'desc')
                ->limit(10)
                ->get();

            // Determine if student can check out
            if ($absensiHariIni) {
                if ($absensiHariIni->status_dinas === 'disetujui') {
                    // Jika sedang dinas luar, bisa pulang langsung tanpa harus masuk
                    $canPulang = !$absensiHariIni->jam_pulang;
                } else {
                    // Normal case: harus sudah masuk dan belum pulang
                    $canPulang = $absensiHariIni->jam_masuk && !$absensiHariIni->jam_pulang && $absensiHariIni->status !== 'izin';
                }
            }
        }

        // Get pending status
        $absensiPending = AbsensiPending::where('user_id', $user->id)
            ->whereDate('tanggal', Carbon::today())
            ->get();

        $izinPending = IzinPending::where('user_id', $user->id)
            ->whereDate('tanggal', Carbon::today())
            ->get();

        return view('siswa.absensi.index', compact(
            'absensiHariIni',
            'riwayatAbsensi',
            'absensiPending',
            'izinPending',
            'canPulang'
        ));
    }
    public function masuk(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $today = Carbon::today();
            $now = Carbon::now();

            // Validasi apakah user sudah terdaftar di IDUKA
            if (!$user->idukaDiterima) {
                return redirect()->back()->with('error', 'Anda belum terdaftar di IDUKA. Silakan hubungi administrator.');
            }

            // VALIDASI: Pastikan user memiliki pembimbing_id yang valid
            if (!$user->pembimbing_id) {
                return redirect()->back()->with('error', 'Anda belum memiliki pembimbing. Silakan hubungi administrator.');
            }

            // VALIDASI: Pastikan pembimbing_id ada di tabel gurus
            $pembimbingExists = \App\Models\Guru::where('id', $user->pembimbing_id)->exists();
            if (!$pembimbingExists) {
                Log::error('Pembimbing tidak ditemukan di tabel gurus', [
                    'user_id' => $user->id,
                    'pembimbing_id' => $user->pembimbing_id
                ]);
                return redirect()->back()->with('error', 'Data pembimbing tidak valid. Silakan hubungi administrator.');
            }

            // Cek apakah sudah ada absensi masuk hari ini
            $existingAbsensi = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', $today)
                ->first();

            if ($existingAbsensi) {
                return redirect()->back()->with('error', 'Anda sudah melakukan absensi masuk hari ini.');
            }

            // Cek apakah sudah ada pending absensi masuk hari ini
            $existingPending = AbsensiPending::where('user_id', $user->id)
                ->whereDate('tanggal', $today)
                ->where('jenis', 'masuk')
                ->first();

            if ($existingPending) {
                return redirect()->back()->with('info', 'Anda sudah memiliki absensi masuk yang menunggu konfirmasi.');
            }

            // Validasi koordinat jika dikirim
            if ($request->has('latitude') && $request->has('longitude')) {
                $request->validate([
                    'latitude' => 'numeric|between:-90,90',
                    'longitude' => 'numeric|between:-180,180',
                ]);
            }

            // Tentukan status berdasarkan waktu
            $status = $this->getStatusAbsensi($now);

            // Create pending absensi dengan SEMUA field yang diperlukan
            $pendingData = [
                'user_id' => $user->id,
                'iduka_id' => $user->idukaDiterima->id,
                'pembimbing_id' => $user->pembimbing_id, // Merujuk ke tabel gurus
                'tanggal' => $today->format('Y-m-d'),
                'jenis' => 'masuk',
                'jam' => $now->format('Y-m-d H:i:s'),
                'status' => $status,
                'status_konfirmasi' => 'pending',
                'validasi_iduka' => 'pending',              // BARU
                'validasi_pembimbing' => 'pending',
                'approved_iduka_at' => null,                // BARU
                'approved_pembimbing_at' => null,
            ];

            // Tambahkan field opsional jika ada
            if ($request->filled('latitude')) {
                $pendingData['latitude'] = $request->latitude;
            }

            if ($request->filled('longitude')) {
                $pendingData['longitude'] = $request->longitude;
            }

            if ($request->filled('keterangan')) {
                $pendingData['keterangan'] = $request->keterangan;
            }

            AbsensiPending::create($pendingData);

            DB::commit();

            Log::info('Absensi masuk pending berhasil dibuat', [
                'user_id' => $user->id,
                'pembimbing_id' => $user->pembimbing_id,
                'pembimbing_name' => $user->pembimbing->nama ?? 'N/A',
                'jam' => $now->format('Y-m-d H:i:s'),
                'status' => $status
            ]);

            return redirect()->back()->with('success', 'Absen masuk berhasil, menunggu konfirmasi IDUKA dan Pembimbing.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in absen masuk: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat absen masuk: ' . $e->getMessage());
        }
    }

    /**
     * Determine attendance status based on current time
     */
    private function getStatusAbsensi($waktu)
    {
        $jamMasuk = Carbon::createFromTime(8, 0, 0); // Default: 08:00
        $batasLambat = Carbon::createFromTime(8, 15, 0); // Default: 08:15

        // You can make these configurable per IDUKA if needed
        $user = Auth::user();
        if ($user->idukaDiterima && $user->idukaDiterima->jam_masuk) {
            $jamMasuk = Carbon::createFromTimeString($user->idukaDiterima->jam_masuk);
            $batasLambat = $jamMasuk->copy()->addMinutes(15);
        }

        if ($waktu->format('H:i:s') <= $jamMasuk->format('H:i:s')) {
            return 'tepat_waktu';
        } elseif ($waktu->format('H:i:s') <= $batasLambat->format('H:i:s')) {
            return 'terlambat';
        } else {
            return 'terlambat';
        }
    }

    public function pulang(Request $request)
    {
        Log::info('=== ABSEN PULANG DIPANGGIL ===', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();

            if (!$user->idukaDiterima) {
                return redirect()->back()->with('error', 'Anda tidak terdaftar di IDUKA manapun.');
            }

            $iduka = $user->idukaDiterima;

            // Cari record absensi hari ini
            $absensiHariIni = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            if (!$absensiHariIni) {
                return redirect()->back()->with('error', 'Anda belum memiliki record absensi hari ini.');
            }

            // Jika sedang izin, tidak bisa absen pulang
            if ($absensiHariIni->status === 'izin') {
                return redirect()->back()->with('error', 'Anda sedang izin hari ini. Tidak bisa melakukan absensi pulang.');
            }

            // Jika sudah absen pulang
            if ($absensiHariIni->jam_pulang) {
                return redirect()->back()->with('error', 'Anda sudah melakukan absen pulang hari ini pada ' . $absensiHariIni->jam_pulang->format('H:i'));
            }

            // Logika utama untuk dinas luar
            if ($absensiHariIni->status_dinas === 'disetujui') {
                // Untuk dinas luar, langsung izinkan absen pulang
                Log::info('Siswa sedang dinas luar, diizinkan absen pulang langsung');
            } else {
                // Untuk kasus normal, harus sudah absen masuk
                if (!$absensiHariIni->jam_masuk) {
                    return redirect()->back()->with('error', 'Anda belum melakukan absen masuk hari ini.');
                }
            }

            // Validasi jam pulang minimal jam 15:00 untuk normal, tapi fleksibel untuk dinas luar
            if ($absensiHariIni->status_dinas !== 'disetujui') {
                if (Carbon::now()->lt(Carbon::today()->setHour(15))) {
                    return redirect()->back()->with(
                        'error',
                        'Absen pulang hanya dapat dilakukan setelah jam 15:00.'
                    );
                }
            }

            // Simpan absensi pulang
            $absensiHariIni->update([
                'jam_pulang' => Carbon::now(),
                'latitude_pulang' => $request->latitude,
                'longitude_pulang' => $request->longitude,
            ]);

            DB::commit();

            Log::info('Absensi pulang berhasil disimpan');
            return redirect()->back()->with('success', 'Absensi pulang berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('ERROR saat menyimpan absensi pulang', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan absensi: ' . $e->getMessage());
        }
    }

    public function izin(Request $request)
    {
        Log::info('=== AJUKAN IZIN DIPANGGIL ===', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $request->validate([
            'jenis_izin' => 'required|string|in:sakit,keperluan_keluarga,keperluan_sekolah,lainnya',
            'keterangan' => 'required|string|min:10|max:500',
        ], [
            'jenis_izin.required' => 'Jenis izin harus dipilih.',
            'jenis_izin.in' => 'Jenis izin tidak valid.',
            'keterangan.required' => 'Keterangan izin harus diisi.',
            'keterangan.min' => 'Keterangan izin minimal 10 karakter.',
            'keterangan.max' => 'Keterangan izin maksimal 500 karakter.',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();

            if (!$user->idukaDiterima) {
                return redirect()->back()->with('error', 'Anda tidak terdaftar di IDUKA manapun. Silakan hubungi administrator.');
            }

            $iduka = $user->idukaDiterima;

            // Check if already has attendance record today
            $absensiHariIni = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            if ($absensiHariIni) {
                if ($absensiHariIni->status === 'izin') {
                    return redirect()->back()->with('error', 'Anda sudah mengajukan izin hari ini.');
                } else {
                    return redirect()->back()->with('error', 'Anda sudah memiliki record absensi hari ini. Tidak bisa mengajukan izin.');
                }
            }

            // Check if there's pending izin
            $izinPendingHariIni = IzinPending::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            if ($izinPendingHariIni) {
                return redirect()->back()->with('info', 'Anda sudah mengajukan izin. Menunggu konfirmasi IDUKA.');
            }

            // Save to pending table instead of main table
            IzinPending::create([
                'user_id' => $user->id,
                'iduka_id' => $iduka->id,
                'tanggal' => Carbon::today(),
                'jenis_izin' => $request->jenis_izin,
                'keterangan' => $request->keterangan,
                'status_konfirmasi' => 'pending'
            ]);

            DB::commit();

            $jenisIzinText = [
                'sakit' => 'Sakit',
                'lainnya' => 'Lainnya'
            ];

            return redirect()->back()->with(
                'success',
                'Izin berhasil diajukan untuk hari ini. Menunggu konfirmasi IDUKA. Jenis: ' . $jenisIzinText[$request->jenis_izin] .
                '. Alasan: ' . $request->keterangan
            );

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('ERROR saat mengajukan izin', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengajukan izin: ' . $e->getMessage());
        }
    }

    /**
     * Validate if user location is within IDUKA radius
     */
    private function validateLocation($latUser, $longUser, $latTarget, $longTarget, $radius)
    {
        // Ensure all inputs are float
        $latUser = floatval($latUser);
        $longUser = floatval($longUser);
        $latTarget = floatval($latTarget);
        $longTarget = floatval($longTarget);
        $radius = floatval($radius);

        Log::info('Validasi lokasi', [
            'user_lat' => $latUser,
            'user_lng' => $longUser,
            'target_lat' => $latTarget,
            'target_lng' => $longTarget,
            'radius' => $radius
        ]);

        // Check if target coordinates are valid
        if ($latTarget == 0 && $longTarget == 0) {
            Log::warning('Koordinat IDUKA tidak valid');
            return [
                'distance' => 0,
                'isWithinRadius' => true,
            ];
        }

        // Calculate distance using Haversine formula
        $earthRadius = 6371000; // Earth radius in meters

        $latFrom = deg2rad($latUser);
        $lonFrom = deg2rad($longUser);
        $latTo = deg2rad($latTarget);
        $lonTo = deg2rad($longTarget);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2);

        $c = 2 * asin(sqrt($a));

        $distance = $earthRadius * $c;

        $isWithinRadius = $distance <= $radius;

        Log::info('Hasil kalkulasi jarak', [
            'distance' => $distance,
            'is_within_radius' => $isWithinRadius
        ]);

        return [
            'distance' => $distance,
            'isWithinRadius' => $isWithinRadius,
        ];
    }

    /**
     * Get attendance status for API/AJAX requests
     */
    public function getStatus()
    {
        try {
            $user = Auth::user();

            if (!$user->idukaDiterima) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak terdaftar di IDUKA manapun'
                ]);
            }

            $absensiHariIni = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            // Check pending status
            $absensiPending = AbsensiPending::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->get();

            $izinPending = IzinPending::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            return response()->json([
                'success' => true,
                'data' => [
                    'sudah_masuk' => $absensiHariIni && $absensiHariIni->jam_masuk ? true : false,
                    'sudah_pulang' => $absensiHariIni && $absensiHariIni->jam_pulang ? true : false,
                    'sedang_izin' => $absensiHariIni && $absensiHariIni->status === 'izin' ? true : false,
                    'jam_masuk' => $absensiHariIni ? $absensiHariIni->jam_masuk?->format('H:i') : null,
                    'jam_pulang' => $absensiHariIni ? $absensiHariIni->jam_pulang?->format('H:i') : null,
                    'status' => $absensiHariIni ? $absensiHariIni->status : null,
                    'jenis_izin' => $absensiHariIni && $absensiHariIni->status === 'izin' ? $absensiHariIni->jenis_izin : null,
                    'keterangan_izin' => $absensiHariIni && $absensiHariIni->status === 'izin' ? $absensiHariIni->keterangan_izin : null,
                    'pending_masuk' => $absensiPending->where('jenis', 'masuk')->count() > 0,
                    'pending_pulang' => $absensiPending->where('jenis', 'pulang')->count() > 0,
                    'pending_izin' => $izinPending ? true : false,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cekStatusIzin()
    {
        try {
            $user = Auth::user();

            if (!$user->idukaDiterima) {
                return response()->json([
                    'has_attendance' => false,
                    'has_approved_izin' => false,
                    'has_pending_izin' => false,
                    'error' => 'Anda tidak terdaftar di IDUKA manapun'
                ]);
            }

            // Check if already has attendance record today
            $absensiHariIni = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            $hasAttendance = (bool) $absensiHariIni;
            $hasApprovedIzin = $absensiHariIni && $absensiHariIni->status === 'izin';

            // Check if there's pending izin
            $hasPendingIzin = IzinPending::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->exists();

            return response()->json([
                'has_attendance' => $hasAttendance,
                'has_approved_izin' => $hasApprovedIzin,
                'has_pending_izin' => $hasPendingIzin
            ]);

        } catch (\Exception $e) {
            Log::error('Error in cekStatusIzin: ' . $e->getMessage());
            return response()->json([
                'has_attendance' => false,
                'has_approved_izin' => false,
                'has_pending_izin' => false,
                'error' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    // Tambahkan method ini di AbsensiController
    public function dinasLuar(Request $request)
    {
        Log::info('=== AJUKAN DINAS LUAR DIPANGGIL ===', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $request->validate([
            'jenis_dinas' => 'required|string|in:perusahaan,sekolah,instansi_pemerintah,lainnya',
            'keterangan' => 'required|string|min:10|max:500',
        ], [
            'jenis_dinas.required' => 'Jenis dinas harus dipilih.',
            'jenis_dinas.in' => 'Jenis dinas tidak valid.',
            'keterangan.required' => 'Keterangan dinas harus diisi.',
            'keterangan.min' => 'Keterangan dinas minimal 10 karakter.',
            'keterangan.max' => 'Keterangan dinas maksimal 500 karakter.',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();

            if (!$user->idukaDiterima) {
                return redirect()->back()->with('error', 'Anda tidak terdaftar di IDUKA manapun. Silakan hubungi administrator.');
            }

            $iduka = $user->idukaDiterima;

            // Check if already has attendance record today
            $absensiHariIni = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            if ($absensiHariIni) {
                if ($absensiHariIni->status === 'dinas') {
                    return redirect()->back()->with('error', 'Anda sudah mengajukan dinas luar hari ini.');
                } else {
                    return redirect()->back()->with('error', 'Anda sudah memiliki record absensi hari ini. Tidak bisa mengajukan dinas luar.');
                }
            }

            // Check if there's pending dinas
            $dinasPendingHariIni = DinasPending::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            if ($dinasPendingHariIni) {
                return redirect()->back()->with('info', 'Anda sudah mengajukan dinas luar. Menunggu konfirmasi IDUKA.');
            }

            // Save to pending table
            DinasPending::create([
                'user_id' => $user->id,
                'iduka_id' => $iduka->id,
                'tanggal' => Carbon::today(),
                'jenis_dinas' => $request->jenis_dinas,
                'keterangan' => $request->keterangan,
                'status_konfirmasi' => 'pending'
            ]);

            DB::commit();

            $jenisDinasText = [
                'perusahaan' => 'Perusahaan',
                'sekolah' => 'Sekolah',
                'instansi_pemerintah' => 'Instansi Pemerintah',
                'lainnya' => 'Lainnya'
            ];

            return redirect()->back()->with(
                'success',
                'Dinas luar berhasil diajukan untuk hari ini. Menunggu konfirmasi IDUKA. Jenis: ' . $jenisDinasText[$request->jenis_dinas] .
                '. Alasan: ' . $request->keterangan
            );

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('ERROR saat mengajukan dinas luar', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengajukan dinas luar: ' . $e->getMessage());
        }
    }

    public function cekStatusDinas()
    {
        try {
            $user = Auth::user();

            if (!$user->idukaDiterima) {
                return response()->json([
                    'has_attendance' => false,
                    'has_approved_dinas' => false,
                    'has_pending_dinas' => false,
                    'error' => 'Anda tidak terdaftar di IDUKA manapun'
                ]);
            }

            // Check if already has attendance record today
            $absensiHariIni = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            $hasAttendance = (bool) $absensiHariIni;
            $hasApprovedDinas = $absensiHariIni && $absensiHariIni->status === 'dinas';

            // Check if there's pending dinas
            $hasPendingDinas = DinasPending::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->exists();

            return response()->json([
                'has_attendance' => $hasAttendance,
                'has_approved_dinas' => $hasApprovedDinas,
                'has_pending_dinas' => $hasPendingDinas
            ]);

        } catch (\Exception $e) {
            Log::error('Error in cekStatusDinas: ' . $e->getMessage());
            return response()->json([
                'has_attendance' => false,
                'has_approved_dinas' => false,
                'has_pending_dinas' => false,
                'error' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }
}
