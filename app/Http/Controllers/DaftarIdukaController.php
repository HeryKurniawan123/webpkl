<?php

namespace App\Http\Controllers;

use App\Models\Iduka;
use App\Models\User;
use Illuminate\Http\Request;

class DaftarIdukaController extends Controller
{
    public function index()
    {
        $data = User::where('role', 'iduka')
        ->orderBy('name', 'asc')
        ->get();
        return view('hubin.iduka.daftar', compact('data'));
    }
}
