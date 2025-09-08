<?php

namespace App\Http\Controllers;

use App\Exports\SiswaProgres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProgresSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Subquery pengajuan_pkl terbaru
        $latestPkl = DB::table('pengajuan_pkl as p1')
            ->select('p1.*')
            ->join(
                DB::raw('(SELECT siswa_id, MAX(created_at) as latest
                          FROM pengajuan_pkl
                          GROUP BY siswa_id) as p2'),
                function ($join) {
                    $join->on('p1.siswa_id', '=', 'p2.siswa_id')
                        ->on('p1.created_at', '=', 'p2.latest');
                }
            );

        // Subquery pengajuan_usulans terbaru
        $latestUsulan = DB::table('pengajuan_usulans as pu1')
            ->select('pu1.*')
            ->join(
                DB::raw('(SELECT user_id, MAX(created_at) as latest
                          FROM pengajuan_usulans
                          GROUP BY user_id) as pu2'),
                function ($join) {
                    $join->on('pu1.user_id', '=', 'pu2.user_id')
                        ->on('pu1.created_at', '=', 'pu2.latest');
                }
            );

        $query = DB::table('users as u')
            ->select(
                'u.id',
                'u.name as nama_siswa',
                'k.kelas',
                'ko.name_konke as jurusan',
                'i.nama as nama_iduka',
                'pu.status as status_usulan',
                'pu.surat_izin as status_surat_usulan',
                'p.status as status_pengajuan'
            )
            ->join('kelas as k', 'u.kelas_id', '=', 'k.id')
            ->join('konkes as ko', 'k.konke_id', '=', 'ko.id')
            ->leftJoinSub($latestPkl, 'p', function ($join) {
                $join->on('u.id', '=', 'p.siswa_id');
            })
            ->leftJoinSub($latestUsulan, 'pu', function ($join) {
                $join->on('u.id', '=', 'pu.user_id');
            })
            ->leftJoin('idukas as i', 'p.iduka_id', '=', 'i.id')
            ->where('u.role', 'siswa')
            ->orderByDesc('u.id');

        // 🔍 filter jika ada
        if ($request->filled('nama_iduka')) {
            $search = $request->nama_iduka;
            $query->where(function ($q) use ($search) {
                $q->where('i.nama', 'like', '%' . $search . '%')
                    ->orWhere('ko.name_konke', 'like', '%' . $search . '%')
                    ->orWhere('u.name', 'like', '%' . $search . '%');
            });
        }


        $siswa = $query->paginate(10);

        // Hitung data usulan
        $totalUsulan = DB::table('pengajuan_usulans')->count();
        $totalUsulanDiterima = DB::table('pengajuan_usulans')->where('status', 'diterima')->count();
        $totalUsulanDitolak = DB::table('pengajuan_usulans')->where('status', 'ditolak')->count();

        // Hitung data pengajuan PKL
        $totalPengajuan = DB::table('pengajuan_pkl')->count();
        $totalPengajuanDiterima = DB::table('pengajuan_pkl')->where('status', 'diterima')->count();
        $totalPengajuanDitolak = DB::table('pengajuan_pkl')->where('status', 'ditolak')->count();

        return view('siswa_progres.index', compact(
            'siswa',
            'totalUsulan',
            'totalUsulanDiterima',
            'totalUsulanDitolak',
            'totalPengajuan',
            'totalPengajuanDiterima',
            'totalPengajuanDitolak'
        ));
    }


    public function export()
    {
        $siswa = DB::table('users as u')
            ->join('kelas as k', 'u.kelas_id', '=', 'k.id')
            ->join('konkes as ko', 'k.konke_id', '=', 'ko.id')
            ->leftJoin('pengajuan_pkl as p', 'u.id', '=', 'p.siswa_id')
            ->leftJoin('idukas as i', 'p.iduka_id', '=', 'i.id')
            ->leftJoin('pengajuan_usulans as pu', 'u.id', '=', 'pu.user_id')
            ->where('u.role', 'siswa')
            ->select(
                'u.id',
                'u.name as nama_siswa',
                'k.kelas',
                'ko.name_konke as jurusan',
                'i.nama as nama_iduka',
                'p.status as status_pengajuan',
                'pu.status as status_usulan',
                'pu.surat_izin as status_surat_usulan'
            )
            ->groupBy('u.id', 'u.name', 'k.kelas', 'ko.name_konke', 'i.nama', 'p.status', 'pu.status', 'pu.surat_izin')
            ->orderByDesc('u.id')
            ->get();

        return Excel::download(new SiswaProgres($siswa), 'data_siswa_pkl.xlsx');
    }
}
