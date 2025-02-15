<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index() {
        return view('siswa.datasiswa.datasiswa');
    }

    public function show() {
        return view('siswa.datasiswa.detailSiswa');
    }
}
