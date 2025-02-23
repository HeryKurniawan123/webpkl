<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenagaKependidikanController extends Controller
{
    public function tenagaKependidikan() {
        return view('tk.dataTk');
    }
}
