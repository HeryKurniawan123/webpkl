<?php

namespace App\Http\Controllers;

use App\Exports\JurusanKehadiranExport;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DataAbsensiController extends Controller
{
    public function index()
    {
        // Hitung total siswa PKL (siswa dengan role siswa dan memiliki iduka_id)
        $totalSiswaPKL = User::where('role', 'siswa')
            ->count();

        // Kehadiran hari ini
        $hadirHariIni = DB::table('absensi')
            ->whereDate('tanggal', Carbon::today())
            ->distinct('user_id')
            ->count('user_id');

        $tidakHadir = $totalSiswaPKL - $hadirHariIni;

        $tingkatKehadiran = $totalSiswaPKL > 0
            ? round(($hadirHariIni / $totalSiswaPKL) * 100, 2)
            : 0;

        // Data 7 hari terakhir
        $mingguan = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i)->toDateString();

            $hadir = DB::table('absensi')
                ->whereDate('tanggal', $tanggal)
                ->distinct('user_id')
                ->count('user_id');

            $mingguan[] = [
                'tanggal' => Carbon::parse($tanggal)->translatedFormat('l'), // Senin, Selasa...
                'hadir' => $hadir,
            ];
        }

        $jurusanData = $this->getKehadiranJurusan();

        return view('data.absensi-siswa.index', compact(
            'totalSiswaPKL',
            'hadirHariIni',
            'tidakHadir',
            'tingkatKehadiran',
            'mingguan',
            'jurusanData'
        ));
    }

    public function chartData(Request $request)
    {
        $filter = $request->get('filter', '7'); // default 7 hari
        $labels = [];
        $values = [];

        if ($filter === 'today') {
            $tanggal = Carbon::today()->toDateString();
            $hadir = DB::table('absensi')
                ->whereDate('tanggal', $tanggal)
                ->distinct('user_id')
                ->count('user_id');

            $labels = [Carbon::parse($tanggal)->translatedFormat('d M Y')];
            $values = [$hadir];
        } else {
            $days = (int) $filter;
            for ($i = $days - 1; $i >= 0; $i--) {
                $tanggal = Carbon::today()->subDays($i)->toDateString();

                $hadir = DB::table('absensi')
                    ->whereDate('tanggal', $tanggal)
                    ->distinct('user_id')
                    ->count('user_id');

                $labels[] = Carbon::parse($tanggal)->translatedFormat('d M');
                $values[] = $hadir;
            }
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    public function getAttendanceChart(Request $request)
    {
        $filter = $request->get('filter', '7'); // default 7 hari
        $labels = [];
        $values = [];

        if ($filter === 'today') {
            $labels = [Carbon::today()->format('d M Y')];
            $values = [Absensi::whereDate('tanggal', Carbon::today())->count()];
        } else {
            $days = $filter === '30' ? 30 : ($filter === '90' ? 90 : 7);

            $data = Absensi::select(
                DB::raw('DATE(tanggal) as tgl'),
                DB::raw('COUNT(*) as total')
            )
                ->whereDate('tanggal', '>=', Carbon::today()->subDays($days))
                ->groupBy('tgl')
                ->orderBy('tgl', 'asc')
                ->get();

            $labels = $data->pluck('tgl')->map(fn($d) => Carbon::parse($d)->translatedFormat('d M'))->toArray();
            $values = $data->pluck('total')->toArray();
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    public function getJurusanChart()
    {
        $data = DB::table('users')
            ->join('konkes', 'users.konke_id', '=', 'konkes.id')
            ->select('konkes.nama as jurusan', DB::raw('COUNT(users.id) as total'))
            ->where('users.role', 'siswa')
            ->groupBy('konkes.nama')
            ->get();

        $labels = $data->pluck('jurusan');
        $values = $data->pluck('total');

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    public function getKehadiranJurusan()
    {
        // Hitung jumlah siswa per jurusan dan kehadiran hari ini per jurusan
        $jurusanData = DB::table('konkes')
            ->leftJoin('users', 'users.konke_id', '=', 'konkes.id')
            // join absensi hanya yang tanggal = hari ini (ubah sesuai kebutuhan)
            ->leftJoin('absensi', function ($join) {
                $join->on('absensi.user_id', '=', 'users.id')
                    ->whereDate('absensi.tanggal', Carbon::today());
            })
            ->select(
                'konkes.id',
                'konkes.name_konke as jurusan',
                DB::raw('COUNT(DISTINCT users.id) as total_siswa'),
                DB::raw('COUNT(absensi.id) as total_hadir_today')
            )
            ->where('users.role', 'siswa')
            ->groupBy('konkes.id', 'konkes.name_konke')
            ->get();

        // map jadi array rapi
        $hasil = $jurusanData->map(function ($item) {
            $total_siswa = (int) $item->total_siswa;
            $total_hadir = (int) $item->total_hadir_today;
            $persentase = $total_siswa > 0 ? round(($total_hadir / $total_siswa) * 100) : 0;

            return [
                'jurusan' => $item->jurusan,
                'total_siswa' => $total_siswa,
                'persentase' => $persentase,
            ];
        });

        return $hasil; // Collection of arrays
    }

    public function exportJurusan()
    {
        return Excel::download(new JurusanKehadiranExport(), 'kehadiran_jurusan.xlsx');
    }

    // METHOD BARU UNTUK MENDAPATKAN SISWA BELUM ABSEN
// METHOD BARU UNTUK MENDAPATKAN SISWA BELUM ABSEN
    public function getSiswaBelumAbsen()
    {
        try {
            // Log untuk debugging
            \Log::info('Memulai getSiswaBelumAbsen');

            // Ambil semua user dengan role siswa yang memiliki iduka_id (sudah diterima PKL) dan belum absen hari ini
            $siswaBelumAbsen = User::where('role', 'siswa')
                ->whereNotNull('iduka_id') // Menandakan siswa sudah diterima PKL
                ->whereDoesntHave('absensi', function ($query) {
                    $query->whereDate('tanggal', Carbon::today());
                })
                ->with(['konke', 'idukaDiterima']) // Load relasi yang diperlukan
                ->get();

            \Log::info('Jumlah siswa belum absen: ' . $siswaBelumAbsen->count());

            // Format data untuk response
            $data = $siswaBelumAbsen->map(function ($siswa, $index) {
                return [
                    'no' => $index + 1,
                    'name' => $siswa->name ?? '-',
                    'email' => $siswa->email ?? '-',
                    'nip' => $siswa->nip ?? '-',
                    'iduka_id' => $siswa->iduka_id ?? '-',
                    'pembimbing_id' => $siswa->pembimbing_id ?? '-',
                ];
            });

            \Log::info('Data siswa belum absen: ' . json_encode($data));

            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Error di getSiswaBelumAbsen: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
