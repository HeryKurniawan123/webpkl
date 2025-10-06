<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\DinasPending;
use App\Models\Iduka;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\AbsensiPending;
use App\Models\IzinPending;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Notifications\ReminderNotification;


class KonfirAbsenSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

  public function index()
{
    try {
        $user = Auth::user();

        if (!in_array($user->role, ['iduka', 'guru'])) {
            return redirect()->back()->with('error', 'Akses tidak diizinkan');
        }

        // === Untuk IDUKA ===
        if ($user->role === 'iduka') {
            $absensiHariIni = Absensi::with(['user', 'iduka'])
                ->where('iduka_id', $user->iduka_id)
                ->whereDate('tanggal', Carbon::today())
                ->get();

            $absensiPending = AbsensiPending::with(['user', 'iduka'])
                ->where('iduka_id', $user->iduka_id)
                ->where('status_konfirmasi', 'pending')
                ->latest()
                ->get();

            $izinPending = IzinPending::with(['user', 'iduka'])
                ->where('iduka_id', $user->iduka_id)
                ->where('status_konfirmasi', 'pending')
                ->latest()
                ->get();

            $dinasPending = DinasPending::with(['user', 'iduka'])
                ->where('iduka_id', $user->iduka_id)
                ->where('status_konfirmasi', 'pending')
                ->latest()
                ->get();

            $siswaList = User::where('role', 'siswa')
                ->where('iduka_id', $user->iduka_id)
                ->orderBy('name')
                ->get();

            // ambil data iduka yang login untuk kordinat
            $iduka = Iduka::find($user->iduka_id);

        } else {
            // === Untuk Guru/Pembimbing ===
            $guru = Guru::where('user_id', $user->id)->first();

            if (!$guru) {
                Log::warning('Data guru tidak ditemukan', ['user_id' => $user->id]);
                return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
            }

            $siswaIds = User::where('role', 'siswa')
                ->where('pembimbing_id', $guru->id)
                ->pluck('id')
                ->toArray();

            $absensiHariIni = Absensi::with(['user', 'iduka'])
                ->whereIn('user_id', $siswaIds)
                ->whereDate('tanggal', Carbon::today())
                ->get();

            $absensiPending = AbsensiPending::with(['user', 'iduka', 'pembimbing'])
                ->where('pembimbing_id', $guru->id)
                ->where('status_konfirmasi', 'pending')
                ->latest()
                ->get();

            $izinPending = IzinPending::with(['user', 'iduka'])
                ->whereIn('user_id', $siswaIds)
                ->where('status_konfirmasi', 'pending')
                ->latest()
                ->get();

            $dinasPending = DinasPending::with(['user', 'iduka'])
                ->whereIn('user_id', $siswaIds)
                ->where('status_konfirmasi', 'pending')
                ->latest()
                ->get();

            $siswaList = User::where('role', 'siswa')
                ->where('pembimbing_id', $guru->id)
                ->orderBy('name')
                ->get();

            // guru bisa lihat semua iduka
            $iduka = null;
        }

        // Hitung statistik (fungsi kamu sendiri)
        $statistik = $this->hitungStatistik($user);
        $idukas = Iduka::all(); // untuk dropdown

        return view('iduka.konfir_absen_siswa.index', compact(
            'absensiHariIni',
            'absensiPending',
            'izinPending',
            'dinasPending',
            'siswaList',
            'statistik',
            'idukas',
            'iduka'
        ));
    } catch (\Exception $e) {
        Log::error('Error in KonfirAbsenSiswaController@index: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


    /**
     * Konfirmasi izin siswa - FIXED VERSION
     */
    public function konfirmasiIzin(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            Log::info('=== KONFIRMASI IZIN DIMULAI ===', [
                'izin_id' => $id,
                'status' => $request->status,
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role
            ]);

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:disetujui,ditolak',
                'catatan' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $izinPending = IzinPending::find($id);

            if (!$izinPending) {
                Log::error('Izin pending tidak ditemukan', ['id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Data izin tidak ditemukan'
                ], 404);
            }

            $user = Auth::user();

            // Validasi authorization berdasarkan role
            if ($user->role === 'iduka') {
                // Untuk IDUKA - pastikan izin ini milik IDUKA yang sedang login
                if (!$izinPending->iduka_id || $izinPending->iduka_id != $user->iduka_id) {
                    Log::warning('IDUKA tidak berwenang mengkonfirmasi izin ini', [
                        'izin_iduka_id' => $izinPending->iduka_id,
                        'user_iduka_id' => $user->iduka_id
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized access - Bukan IDUKA yang berwenang'
                    ], 403);
                }
            } elseif ($user->role === 'guru') {
                // Untuk Guru - ambil data guru dan validasi pembimbing
                $guru = Guru::where('user_id', $user->id)->first();
                if (!$guru) {
                    Log::error('Data guru tidak ditemukan', ['user_id' => $user->id]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Data guru tidak ditemukan'
                    ], 404);
                }

                // Validasi apakah siswa ini bimbingan guru tersebut
                $siswa = User::where('id', $izinPending->user_id)
                    ->where('pembimbing_id', $guru->id)
                    ->first();

                if (!$siswa) {
                    Log::warning('Guru bukan pembimbing siswa ini', [
                        'guru_id' => $guru->id,
                        'siswa_id' => $izinPending->user_id
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda bukan pembimbing siswa ini'
                    ], 403);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Role tidak diizinkan untuk mengkonfirmasi izin'
                ], 403);
            }

            // Cek apakah sudah dikonfirmasi sebelumnya
            if ($izinPending->status_konfirmasi !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Izin ini sudah dikonfirmasi sebelumnya'
                ], 400);
            }

            // Update status izin
            $izinPending->update([
                'status_konfirmasi' => $request->status,
                'alasan_penolakan' => $request->status === 'ditolak' ? ($request->catatan ?? 'Alasan penolakan tidak diisi') : null
            ]);

            Log::info('Status izin berhasil diupdate', [
                'izin_id' => $id,
                'status_baru' => $request->status
            ]);

            // Jika disetujui, buat record absensi dengan status izin
            if ($request->status === 'disetujui') {
                // Cek apakah sudah ada absensi untuk tanggal tersebut
                $absensiExist = Absensi::where('user_id', $izinPending->user_id)
                    ->whereDate('tanggal', $izinPending->tanggal)
                    ->first();

                if ($absensiExist) {
                    // Update absensi yang sudah ada
                    $absensiExist->update([
                        'status' => 'izin',
                        'jenis_izin' => $izinPending->jenis_izin,
                        'keterangan_izin' => $izinPending->keterangan,
                        'jam_masuk' => null,
                        'jam_pulang' => null,
                    ]);
                    Log::info('Absensi existing diupdate dengan status izin', ['absensi_id' => $absensiExist->id]);
                } else {
                    // Buat absensi baru
                    $absensi = Absensi::create([
                        'user_id' => $izinPending->user_id,
                        'iduka_id' => $izinPending->iduka_id,
                        'tanggal' => $izinPending->tanggal,
                        'status' => 'izin',
                        'jenis_izin' => $izinPending->jenis_izin,
                        'keterangan_izin' => $izinPending->keterangan,
                        'jam_masuk' => null,
                        'jam_pulang' => null,
                        'latitude_masuk' => null,
                        'longitude_masuk' => null,
                        'latitude_pulang' => null,
                        'longitude_pulang' => null,
                    ]);
                    Log::info('Absensi baru dibuat dengan status izin', ['absensi_id' => $absensi->id]);
                }

                // Hapus dari pending setelah disetujui
                $izinPending->delete();
                Log::info('Izin pending dihapus setelah disetujui', ['izin_id' => $id]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Izin berhasil ' . ($request->status === 'disetujui' ? 'disetujui' : 'ditolak')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in konfirmasiIzin: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Method untuk debug data izin pending
     */
    public function debugIzinPending()
    {
        try {
            $user = Auth::user();

            Log::info('=== DEBUG IZIN PENDING ===', ['user_id' => $user->id, 'role' => $user->role]);

            if ($user->role === 'iduka') {
                $izinPending = IzinPending::with(['user', 'iduka'])
                    ->where('iduka_id', $user->iduka_id)
                    ->get();
            } elseif ($user->role === 'guru') {
                $guru = Guru::where('user_id', $user->id)->first();
                if ($guru) {
                    $siswaIds = User::where('pembimbing_id', $guru->id)->pluck('id');
                    $izinPending = IzinPending::with(['user', 'iduka'])
                        ->whereIn('user_id', $siswaIds)
                        ->get();
                } else {
                    $izinPending = collect();
                }
            } else {
                $izinPending = collect();
            }

            return response()->json([
                'success' => true,
                'izin_pending_count' => $izinPending->count(),
                'izin_pending_data' => $izinPending->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'user_id' => $item->user_id,
                        'user_name' => $item->user->name ?? 'N/A',
                        'iduka_id' => $item->iduka_id,
                        'tanggal' => $item->tanggal,
                        'jenis_izin' => $item->jenis_izin,
                        'keterangan' => $item->keterangan,
                        'status_konfirmasi' => $item->status_konfirmasi,
                        'created_at' => $item->created_at
                    ];
                })
            ]);

        } catch (\Exception $e) {
            Log::error('Error in debugIzinPending: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data absensi hari ini via AJAX
     */
    public function getAbsensiHariIni()
    {
        $user = Auth::user();

        $absensiHariIni = Absensi::with(['user'])
            ->where('iduka_id', $user->iduka_id)
            ->whereDate('tanggal', Carbon::today())
            ->get()
            ->map(function ($absensi) {
                return [
                    'id' => $absensi->id,
                    'nama_siswa' => $absensi->user->name,
                    'email_siswa' => $absensi->user->email,
                    'jam_masuk' => $absensi->jam_masuk,
                    'jam_pulang' => $absensi->jam_pulang,
                    'status' => $this->getStatusLabel($absensi->status),
                    'status_class' => $this->getStatusClass($absensi->status),
                    'lokasi' => $absensi->lokasi,
                    'latitude' => $absensi->latitude,
                    'longitude' => $absensi->longitude,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $absensiHariIni
        ]);
    }

    /**
     * Get data absensi pending via AJAX
     */
    public function getAbsensiPending()
    {
        $user = Auth::user();

        $absensiPending = AbsensiPending::with(['user'])
            ->where('iduka_id', $user->iduka_id)
            ->where('status_konfirmasi', 'pending')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($absensi) {
                return [
                    'id' => $absensi->id,
                    'nama_siswa' => $absensi->user->name,
                    'tanggal' => $absensi->tanggal->format('d M Y'),
                    'jenis' => $absensi->jenis,
                    'jam' => $absensi->jam,
                    'status' => $absensi->status,
                    'latitude' => $absensi->latitude,
                    'longitude' => $absensi->longitude,
                    'created_at' => $absensi->created_at->format('d M Y H:i')
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $absensiPending,
            'count' => $absensiPending->count()
        ]);
    }



    /**
     * Filter riwayat absensi
     */
    public function filterRiwayat(Request $request)
    {
        $user = Auth::user();

        $query = Absensi::with(['user'])
            ->where('iduka_id', $user->iduka_id);

        // Filter tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        // Filter siswa
        if ($request->filled('filter_siswa_riwayat')) {
            $query->where('user_id', $request->filter_siswa_riwayat);
        }

        $riwayat = $query->orderBy('tanggal', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $riwayat
        ]);
    }

    /**
     * Hitung statistik kehadiran
     */
    private function hitungStatistik($user)
    {
        $bulanIni = Carbon::now()->startOfMonth();
        $bulanSekarang = Carbon::now()->endOfMonth();

        $query = User::where('role', 'siswa');

        if ($user->role === 'iduka') {
            $query->where('iduka_id', $user->iduka_id);
        } else {
            $query->where('pembimbing_id', $user->id);
        }

        $totalSiswa = $query->count();

        $absensiQuery = Absensi::whereBetween('tanggal', [$bulanIni, $bulanSekarang]);

        if ($user->role === 'iduka') {
            $absensiQuery->where('iduka_id', $user->iduka_id);
        } else {
            $absensiQuery->whereHas('user', function ($q) use ($user) {
                $q->where('pembimbing_id', $user->id);
            });
        }

        $absensiStats = $absensiQuery->selectRaw('
        COUNT(*) as total_absensi,
        SUM(CASE WHEN status = "tepat_waktu" THEN 1 ELSE 0 END) as tepat_waktu,
        SUM(CASE WHEN status = "terlambat" THEN 1 ELSE 0 END) as terlambat,
        SUM(CASE WHEN status = "izin" THEN 1 ELSE 0 END) as izin,
        SUM(CASE WHEN status = "sakit" THEN 1 ELSE 0 END) as sakit,
        SUM(CASE WHEN status = "alpha" THEN 1 ELSE 0 END) as alpha
    ')->first();

        // Hitung persentase kehadiran
        $totalAbsensi = $absensiStats->total_absensi ?? 0;
        $persentaseKehadiran = $totalSiswa > 0 ? round(($totalAbsensi / ($totalSiswa * Carbon::now()->day)) * 100, 2) : 0;

        return [
            'total_siswa' => $totalSiswa,
            'persentase_kehadiran' => $persentaseKehadiran,
            'tepat_waktu' => $absensiStats->tepat_waktu ?? 0,
            'terlambat' => $absensiStats->terlambat ?? 0,
            'izin' => $absensiStats->izin ?? 0,
            'sakit' => $absensiStats->sakit ?? 0,
            'alpha' => $absensiStats->alpha ?? 0,
        ];
    }

    /**
     * Get status label untuk display
     */
    private function getStatusLabel($status)
    {
        return match ($status) {
            'tepat_waktu' => 'Tepat Waktu',
            'terlambat' => 'Terlambat',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get status class untuk styling
     */
    private function getStatusClass($status)
    {
        return match ($status) {
            'tepat_waktu' => 'bg-success',
            'terlambat' => 'bg-warning',
            'izin' => 'bg-info',
            'sakit' => 'bg-secondary',
            'alpha' => 'bg-danger',
            default => 'bg-light'
        };
    }

    /**
     * Export laporan absensi
     */
    public function exportLaporan(Request $request)
    {
        // TODO: Implementasi export ke Excel/PDF
        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil digenerate',
            'download_url' => '#'
        ]);
    }

    public function konfirmasiAbsensi(Request $request, $id)
    {
        try {
            Log::info('=== KONFIRMASI ABSENSI DIMULAI ===', [
                'id' => $id,
                'user_id' => Auth::id(),
                'role' => Auth::user()->role
            ]);

            $absensiPending = AbsensiPending::find($id);

            if (!$absensiPending) {
                Log::warning('Absensi pending tidak ditemukan', ['id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Data absensi tidak ditemukan'
                ], 404);
            }

            $user = Auth::user();

            // Validasi authorization berdasarkan role
            if ($user->role === 'iduka') {
                if (!$absensiPending->iduka_id || $absensiPending->iduka_id != $user->iduka_id) {
                    Log::warning('IDUKA tidak berwenang', [
                        'iduka_id_pending' => $absensiPending->iduka_id,
                        'iduka_id_user' => $user->iduka_id
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak berwenang mengkonfirmasi absensi ini'
                    ], 403);
                }
            } elseif ($user->role === 'guru') {
                $guru = Guru::where('user_id', $user->id)->first();
                if (!$guru || !$absensiPending->pembimbing_id || $absensiPending->pembimbing_id != $guru->id) {
                    Log::warning('Guru bukan pembimbing', [
                        'pembimbing_id_pending' => $absensiPending->pembimbing_id,
                        'guru_id' => $guru ? $guru->id : null
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda bukan pembimbing siswa ini'
                    ], 403);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Role tidak diizinkan untuk mengkonfirmasi absensi'
                ], 403);
            }

            DB::beginTransaction();

            // Update status konfirmasi
            $konfirmator = $user->role === 'iduka' ? 'iduka' : 'guru';

            // Jika sudah ada yang konfirmasi sebelumnya
            if ($absensiPending->dikonfirmasi_oleh) {
                // Jika yang konfirmasi sekarang berbeda dengan sebelumnya
                if ($absensiPending->dikonfirmasi_oleh !== $konfirmator) {
                    $absensiPending->dikonfirmasi_oleh = 'keduanya';
                }
            } else {
                $absensiPending->dikonfirmasi_oleh = $konfirmator;
            }

            $absensiPending->waktu_konfirmasi = now();
            $absensiPending->save();

            // Cari atau buat record absensi
            $absensi = Absensi::where('user_id', $absensiPending->user_id)
                ->where('iduka_id', $absensiPending->iduka_id)
                ->whereDate('tanggal', $absensiPending->tanggal)
                ->first();

            if (!$absensi) {
                $absensi = new Absensi();
                $absensi->user_id = $absensiPending->user_id;
                $absensi->iduka_id = $absensiPending->iduka_id;
                $absensi->tanggal = $absensiPending->tanggal;
                $absensi->status = $absensiPending->status ?? 'hadir';
            }

            // Update data berdasarkan jenis absensi
            if ($absensiPending->jenis === 'masuk') {
                $absensi->jam_masuk = $absensiPending->jam;
                $absensi->latitude_masuk = $absensiPending->latitude;
                $absensi->longitude_masuk = $absensiPending->longitude;
            } elseif ($absensiPending->jenis === 'pulang') {
                $absensi->jam_pulang = $absensiPending->jam;
                $absensi->latitude_pulang = $absensiPending->latitude;
                $absensi->longitude_pulang = $absensiPending->longitude;
            }

            // Simpan absensi
            $absensi->save();

            // Hapus data pending
            $absensiPending->delete();

            DB::commit();

            Log::info('Absensi berhasil dikonfirmasi dan dipindahkan', [
                'pending_id' => $id,
                'absensi_id' => $absensi->id,
                'dikonfirmasi_oleh' => $konfirmator
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dikonfirmasi'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error konfirmasi absensi', [
                'id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * FINAL FIXED - Konfirmasi banyak absensi sekaligus
     */
    public function konfirmasiBanyakAbsen(Request $request)
    {
        try {
            Log::info('=== KONFIRMASI BANYAK ABSENSI DIMULAI ===', [
                'absen_ids' => $request->absen_ids,
                'status' => $request->status,
                'user_id' => Auth::id()
            ]);

            $validator = Validator::make($request->all(), [
                'absen_ids' => 'required|array|min:1',
                'absen_ids.*' => 'required|integer|exists:absensi_pending,id',
                'status' => 'required|in:disetujui,ditolak'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Validasi gagal: ' . implode(', ', $validator->errors()->all()));
            }

            $user = Auth::user();
            $absensiPendings = AbsensiPending::whereIn('id', $request->absen_ids)
                ->where('iduka_id', $user->iduka_id)
                ->where('status_konfirmasi', 'pending')
                ->get();

            if ($absensiPendings->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data absensi pending yang valid untuk dikonfirmasi');
            }

            DB::beginTransaction();

            $berhasil = 0;
            $gagal = 0;

            foreach ($absensiPendings as $absensiPending) {
                try {
                    if ($request->status === 'disetujui') {
                        // Cek apakah absensi sudah ada untuk tanggal tersebut
                        $absensi = Absensi::where('user_id', $absensiPending->user_id)
                            ->where('iduka_id', $absensiPending->iduka_id)
                            ->whereDate('tanggal', $absensiPending->tanggal)
                            ->first();

                        if (!$absensi) {
                            // Buat record absensi baru
                            $absensi = new Absensi();
                            $absensi->user_id = $absensiPending->user_id;
                            $absensi->iduka_id = $absensiPending->iduka_id;
                            $absensi->tanggal = $absensiPending->tanggal;
                            $absensi->status = $absensiPending->status;
                        }

                        // Update data sesuai jenis absensi
                        if ($absensiPending->jenis === 'masuk') {
                            $absensi->jam_masuk = $absensiPending->jam;
                            $absensi->latitude_masuk = $absensiPending->latitude;
                            $absensi->longitude_masuk = $absensiPending->longitude;
                            if (!$absensi->exists) {
                                $absensi->status = $absensiPending->status;
                            }
                        } elseif ($absensiPending->jenis === 'pulang') {
                            $absensi->jam_pulang = $absensiPending->jam;
                            $absensi->latitude_pulang = $absensiPending->latitude;
                            $absensi->longitude_pulang = $absensiPending->longitude;
                        }

                        $absensi->save();
                    }

                    // Update status dan hapus
                    $absensiPending->status_konfirmasi = $request->status;
                    $absensiPending->save();
                    $absensiPending->delete();

                    $berhasil++;

                } catch (\Exception $e) {
                    Log::error('Error processing individual absensi', [
                        'pending_id' => $absensiPending->id,
                        'error' => $e->getMessage()
                    ]);
                    $gagal++;
                }
            }

            DB::commit();

            $message = "Berhasil memproses {$berhasil} absensi";
            if ($gagal > 0) {
                $message .= ", gagal {$gagal} absensi";
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in konfirmasiBanyakAbsen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }


    /**
     * Menolak absensi pending
     */
    public function tolakAbsensi(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            Log::info('=== TOLAK ABSENSI DIMULAI ===', [
                'pending_id' => $id,
                'user_id' => Auth::id(),
                'alasan' => $request->catatan
            ]);

            $absensiPending = AbsensiPending::find($id);

            if (!$absensiPending) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data absensi tidak ditemukan'
                ], 404);
            }

            $user = Auth::user();

            // Validasi authorization
            if ($user->role === 'iduka') {
                if ($absensiPending->iduka_id != $user->iduka_id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized access'
                    ], 403);
                }
            } elseif ($user->role === 'guru') {
                $guru = Guru::where('user_id', $user->id)->first();
                if (!$guru || $absensiPending->pembimbing_id != $guru->id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized access'
                    ], 403);
                }
            }

            // Simpan ke absensi dengan status ditolak
            $absensi = Absensi::where('user_id', $absensiPending->user_id)
                ->where('iduka_id', $absensiPending->iduka_id)
                ->whereDate('tanggal', $absensiPending->tanggal)
                ->first();

            if (!$absensi) {
                $absensi = new Absensi();
                $absensi->user_id = $absensiPending->user_id;
                $absensi->iduka_id = $absensiPending->iduka_id;
                $absensi->tanggal = $absensiPending->tanggal;
                $absensi->status = 'ditolak';
                $absensi->alasan_penolakan = $request->catatan;
            } else {
                $absensi->status = 'ditolak';
                $absensi->alasan_penolakan = $request->catatan;
            }

            // Update data sesuai jenis absensi
            if ($absensiPending->jenis === 'masuk') {
                $absensi->jam_masuk = $absensiPending->jam;
                $absensi->latitude_masuk = $absensiPending->latitude;
                $absensi->longitude_masuk = $absensiPending->longitude;
            } elseif ($absensiPending->jenis === 'pulang') {
                $absensi->jam_pulang = $absensiPending->jam;
                $absensi->latitude_pulang = $absensiPending->latitude;
                $absensi->longitude_pulang = $absensiPending->longitude;
            }

            $absensi->save();

            // Hapus data pending
            $absensiPending->delete();

            DB::commit();

            Log::info('Absensi berhasil ditolak', [
                'pending_id' => $id,
                'absensi_id' => $absensi->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil ditolak' . ($request->catatan ? ' dengan alasan: ' . $request->catatan : '')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in tolakAbsensi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Method untuk cek dan debug absensi pending
     */
    public function debugAbsensiPending()
    {
        $user = Auth::user();

        $pending = AbsensiPending::where('iduka_id', $user->iduka_id)->get();
        $absensi = Absensi::where('iduka_id', $user->iduka_id)->get();

        return response()->json([
            'pending_count' => $pending->count(),
            'absensi_count' => $absensi->count(),
            'pending_data' => $pending->toArray(),
            'absensi_data' => $absensi->toArray()
        ]);
    }

    /**
     * Method untuk proses konfirmasi absensi yang diperbaiki
     */
    public function prosesKonfirmasiAbsen(Request $request, $id)
    {
        try {
            Log::info('=== PROSES KONFIRMASI ABSEN ===', [
                'pending_id' => $id,
                'user_id' => Auth::id()
            ]);

            $absensiPending = AbsensiPending::findOrFail($id);
            $user = Auth::user();

            // Validasi ownership
            if ($absensiPending->iduka_id !== $user->iduka_id) {
                return redirect()->back()->with('error', 'Unauthorized access');
            }

            DB::beginTransaction();

            // Cek apakah sudah ada absensi untuk tanggal tersebut
            $absensi = Absensi::where('user_id', $absensiPending->user_id)
                ->where('iduka_id', $absensiPending->iduka_id)
                ->whereDate('tanggal', $absensiPending->tanggal)
                ->first();

            if (!$absensi) {
                // Buat record absensi baru
                $absensi = new Absensi();
                $absensi->user_id = $absensiPending->user_id;
                $absensi->iduka_id = $absensiPending->iduka_id;
                $absensi->tanggal = $absensiPending->tanggal;
                $absensi->status = $absensiPending->status;
            }

            // Update data sesuai jenis
            if ($absensiPending->jenis === 'masuk') {
                $absensi->jam_masuk = $absensiPending->jam;
                $absensi->latitude_masuk = $absensiPending->latitude;
                $absensi->longitude_masuk = $absensiPending->longitude;
            } elseif ($absensiPending->jenis === 'pulang') {
                $absensi->jam_pulang = $absensiPending->jam;
                $absensi->latitude_pulang = $absensiPending->latitude;
                $absensi->longitude_pulang = $absensiPending->longitude;
            }

            $absensi->save();

            // Hapus pending setelah berhasil
            $absensiPending->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Absensi berhasil dikonfirmasi');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in prosesKonfirmasiAbsen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function konfirmasiDinas(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            Log::info('=== KONFIRMASI DINAS LUAR DIMULAI ===', [
                'dinas_id' => $id,
                'status' => $request->status,
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role
            ]);

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:disetujui,ditolak',
                'catatan' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $dinasPending = DinasPending::find($id);

            if (!$dinasPending) {
                Log::error('Dinas pending tidak ditemukan', ['id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Data dinas tidak ditemukan'
                ], 404);
            }

            $user = Auth::user();

            // Validasi authorization berdasarkan role
            if ($user->role === 'iduka') {
                if (!$dinasPending->iduka_id || $dinasPending->iduka_id != $user->iduka_id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized access - Bukan IDUKA yang berwenang'
                    ], 403);
                }
            } elseif ($user->role === 'guru') {
                $guru = Guru::where('user_id', $user->id)->first();
                if (!$guru) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data guru tidak ditemukan'
                    ], 404);
                }

                $siswa = User::where('id', $dinasPending->user_id)
                    ->where('pembimbing_id', $guru->id)
                    ->first();

                if (!$siswa) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda bukan pembimbing siswa ini'
                    ], 403);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Role tidak diizinkan untuk mengkonfirmasi dinas'
                ], 403);
            }

            // Cek apakah sudah dikonfirmasi sebelumnya
            if ($dinasPending->status_konfirmasi !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Dinas ini sudah dikonfirmasi sebelumnya'
                ], 400);
            }

            // Update status dinas
            $dinasPending->update([
                'status_konfirmasi' => $request->status,
                'alasan_penolakan' => $request->status === 'ditolak' ? ($request->catatan ?? 'Alasan penolakan tidak diisi') : null
            ]);

            // Jika disetujui, buat record absensi dengan status hadir
            if ($request->status === 'disetujui') {
                // Cek apakah sudah ada absensi untuk tanggal tersebut
                $absensiExist = Absensi::where('user_id', $dinasPending->user_id)
                    ->whereDate('tanggal', $dinasPending->tanggal)
                    ->first();

                if ($absensiExist) {
                    // Update absensi yang sudah ada
                    $absensiExist->update([
                        'status' => 'hadir', // Status tetap hadir
                        'jenis_dinas' => $dinasPending->jenis_dinas,
                        'keterangan_dinas' => $dinasPending->keterangan,
                        'status_dinas' => 'disetujui'
                    ]);
                    Log::info('Absensi existing diupdate dengan status dinas', ['absensi_id' => $absensiExist->id]);
                } else {
                    // Buat absensi baru dengan status hadir
                    $absensi = Absensi::create([
                        'user_id' => $dinasPending->user_id,
                        'iduka_id' => $dinasPending->iduka_id,
                        'tanggal' => $dinasPending->tanggal,
                        'status' => 'hadir', // Status tetap hadir
                        'jenis_dinas' => $dinasPending->jenis_dinas,
                        'keterangan_dinas' => $dinasPending->keterangan,
                        'status_dinas' => 'disetujui',
                        // Field absensi kosong karena siswa harus absensi manual
                        'jam_masuk' => null,
                        'jam_pulang' => null,
                        'latitude_masuk' => null,
                        'longitude_masuk' => null,
                        'latitude_pulang' => null,
                        'longitude_pulang' => null,
                    ]);
                    Log::info('Absensi baru dibuat dengan status dinas', ['absensi_id' => $absensi->id]);
                }

                // Hapus dari pending setelah disetujui
                $dinasPending->delete();
                Log::info('Dinas pending dihapus setelah disetujui', ['dinas_id' => $id]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Dinas luar berhasil ' .
                ($request->status === 'disetujui' ? 'disetujui' : 'ditolak'));


        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in konfirmasiDinas: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function kordinat(Request $request)
    {
        $request->validate([
            'iduka_id' => 'required|exists:idukas,id',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'required',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
        ]);

        $iduka = Iduka::find($request->iduka_id);
        $iduka->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang
        ]);

        return redirect()->back()->with('success', 'Koordinat berhasil diperbarui!');
    }


}
