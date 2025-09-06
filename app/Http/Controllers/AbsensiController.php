<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\AbsensiPending;
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
            'izinPending'
        ));
    }

    public function masuk(Request $request)
    {
        Log::info('=== ABSEN MASUK DIPANGGIL ===', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        Log::info('Validasi request berhasil');

        try {
            DB::beginTransaction();
            Log::info('Database transaction dimulai');

            $user = Auth::user();
            Log::info('User data', ['user_id' => $user->id]);

            // Check if user has IDUKA assignment
            if (!$user->idukaDiterima) {
                Log::warning('User tidak memiliki IDUKA assignment');
                return redirect()->back()->with('error', 'Anda tidak terdaftar di IDUKA manapun. Silakan hubungi administrator.');
            }

            $iduka = $user->idukaDiterima;
            Log::info('IDUKA data', [
                'iduka_id' => $iduka->id,
                'nama' => $iduka->nama,
                'latitude' => $iduka->latitude,
                'longitude' => $iduka->longitude,
                'radius' => $iduka->radius
            ]);

            // Check if there's any attendance record today
            $absensiHariIni = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            Log::info('Check absensi hari ini', [
                'ada_absensi' => $absensiHariIni ? true : false,
                'absensi_data' => $absensiHariIni
            ]);

            // Prevent multiple attendance on same day
            if ($absensiHariIni) {
                if ($absensiHariIni->status === 'izin') {
                    Log::info('User sedang izin hari ini');
                    return redirect()->back()->with('error', 'Anda sedang izin hari ini. Tidak bisa melakukan absensi.');
                }

                if ($absensiHariIni->jam_masuk) {
                    Log::info('User sudah absen masuk hari ini');
                    return redirect()->back()->with('error', 'Anda sudah melakukan absen masuk hari ini pada ' . $absensiHariIni->jam_masuk->format('H:i'));
                }
            }

            // Check if there's pending attendance
            $absensiPendingHariIni = AbsensiPending::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->where('jenis', 'masuk')
                ->first();

            if ($absensiPendingHariIni) {
                Log::info('User sudah memiliki absen masuk pending');
                return redirect()->back()->with('info', 'Anda sudah mengajukan absen masuk. Menunggu konfirmasi IDUKA.');
            }

            // Validate location
            $locationValidation = $this->validateLocation(
                $request->latitude,
                $request->longitude,
                $iduka->latitude,
                $iduka->longitude,
                $iduka->radius ?? 100
            );

            Log::info('Hasil validasi lokasi', $locationValidation);

            if (!$locationValidation['isWithinRadius']) {
                Log::warning('User di luar radius IDUKA');
                return redirect()->back()->with(
                    'error',
                    'Anda berada di luar radius IDUKA ' . $iduka->nama . '. ' .
                    'Jarak Anda: ' . round($locationValidation['distance']) . ' meter. ' .
                    'Radius maksimal: ' . ($iduka->radius ?? 100) . ' meter.'
                );
            }

            // Determine attendance status
            $status = $this->getStatusAbsensi(Carbon::now());
            Log::info('Status absensi ditentukan', ['status' => $status]);

            // Save to pending table instead of main table
            AbsensiPending::create([
                'user_id' => $user->id,
                'iduka_id' => $iduka->id,
                'tanggal' => Carbon::today(),
                'jenis' => 'masuk',
                'jam' => Carbon::now(),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,
                'status_konfirmasi' => 'pending',
                'keterangan' => 'Menunggu konfirmasi IDUKA'
            ]);

            DB::commit();
            Log::info('Transaction committed successfully');

            return redirect()->back()->with('success', 'Absensi masuk berhasil diajukan. Menunggu konfirmasi IDUKA.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('ERROR saat menyimpan absensi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan absensi: ' . $e->getMessage());
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

            if ($absensiHariIni->status === 'izin') {
                return redirect()->back()->with('error', 'Anda sedang izin hari ini. Tidak bisa melakukan absensi pulang.');
            }

            if (!$absensiHariIni->jam_masuk) {
                return redirect()->back()->with('error', 'Anda belum melakukan absen masuk hari ini.');
            }

            if ($absensiHariIni->jam_pulang) {
                return redirect()->back()->with('error', 'Anda sudah melakukan absen pulang hari ini pada ' . $absensiHariIni->jam_pulang->format('H:i'));
            }

            //Validasi jam pulang minimal jam 15:00
            if (Carbon::now()->lt(Carbon::today()->setHour(15))) {
                return redirect()->back()->with(
                    'error',
                    'Absen pulang hanya dapat dilakukan setelah jam 15:00.'
                );
            }

            // Simpan langsung ke tabel absensi (tanpa pending)
            $absensiHariIni->update([
                'jam_pulang' => Carbon::now(),
                'latitude_pulang' => $request->latitude,
                'longitude_pulang' => $request->longitude,
            ]);

            DB::commit();

            Log::info('Absensi pulang berhasil disimpan langsung');
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

        Log::info('Penentuan status absensi', [
            'waktu_sekarang' => $waktu->format('H:i:s'),
            'jam_masuk' => $jamMasuk->format('H:i:s'),
            'batas_lambat' => $batasLambat->format('H:i:s')
        ]);

        if ($waktu->format('H:i:s') <= $jamMasuk->format('H:i:s')) {
            return 'tepat_waktu';
        } elseif ($waktu->format('H:i:s') <= $batasLambat->format('H:i:s')) {
            return 'terlambat';
        } else {
            return 'terlambat'; // Still counted as late, not absent
        }
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

}
