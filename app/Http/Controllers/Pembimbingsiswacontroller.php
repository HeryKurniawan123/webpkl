<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Pembimbingsiswacontroller extends Controller
{
    public function index() {
        return view('pembimbing_siswa.index');
    }
}
