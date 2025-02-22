<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function dataguru() {
        return view('hubin.dataguru.dataguru');
    }

    public function detailGuru() {
        return view('hubin.dataguru.detailGuru');
    }
}
