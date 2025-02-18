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
}
