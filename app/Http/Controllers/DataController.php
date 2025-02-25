<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function proker() {
        return view('data.proker.dataproker');
    }

    public function konke() {
        return view('data.konke.dataKonke');
    }

    public function kelas() {
        return view('data.kelas.dataKelas');
    }

    public function dataUsulan(){
        return view('data.usulan.formUsulan');
    }

    public function detailUsulan() {
        return view('data.usulan.detailUsulan');
    }

    public function suratUsulanPDF(){
        return view('data.usulan.suratUsulanPDF');
    }

    public function detailPengajuan() {
        return view('data.usulan.detailPengajuan');
    }
}
