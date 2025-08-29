<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use App\Models\User;
use Illuminate\Http\Request;
use LaporanIdukaExport;
use Maatwebsite\Excel\Facades\Excel;



class LaporanIduka extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Iduka::with('siswa');

        // filter nama iduka
        if ($request->filled('nama_iduka')) {
            $query->where('nama', 'like', '%' . $request->nama_iduka . '%');
        }

        $idukas = $query->paginate(10);

        return view('hubin.laporan_iduka.index', compact('idukas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
    public function showSiswa($id)
    {
        $iduka = Iduka::with('siswa')->findOrFail($id);
        return view('hubin.laporan_iduka.siswa', compact('iduka'));
    }

    public function exportExcel($id)
    {
        $iduka = Iduka::with('siswa')->findOrFail($id);
        return Excel::download(new \App\Exports\LaporanIdukaExport($iduka), 'laporan_iduka_' . $iduka->nama . '.xlsx');
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
