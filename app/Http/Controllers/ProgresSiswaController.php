<?php

namespace App\Http\Controllers;

use App\Exports\SiswaProgres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProgresSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \DB::table('users as u')
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
            ->leftJoin('pengajuan_pkl as p', 'u.id', '=', 'p.siswa_id')
            ->leftJoin('pengajuan_usulans as pu', 'u.id', '=', 'pu.user_id')
            ->leftJoin('idukas as i', 'p.iduka_id', '=', 'i.id')
            ->where('u.role', 'siswa');

        // ðŸ” Filter berdasarkan input pencarian
        if ($request->filled('nama_iduka')) {
            $search = $request->nama_iduka;
            $query->where(function ($q) use ($search) {
                $q->where('i.nama', 'like', '%' . $search . '%')      // cari nama iduka
                    ->orWhere('ko.name_konke', 'like', '%' . $search . '%') // cari jurusan
                    ->orWhere('u.name', 'like', '%' . $search . '%');
            });
        }


        $siswa = $query->paginate(10);

        return view('siswa_progres.index', compact('siswa'));
    }


    public function export()
    {
         $siswa = DB::table('users as u')
        ->join('kelas as k', 'u.kelas_id', '=', 'k.id')
        ->join('konkes as ko', 'u.konke_id', '=', 'ko.id')
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
        ->orderBy('i.nama')
        ->orderBy('u.name')
        ->get();

    return Excel::download(new SiswaProgres($siswa), 'data_siswa_pkl.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
