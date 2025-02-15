<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IdukaController extends Controller
{
    public function index() {
        return view('iduka.dataiduka.dataiduka');
    }

    public function show() {
        return view('iduka.dataiduka.detailDataIduka');
    }
}
