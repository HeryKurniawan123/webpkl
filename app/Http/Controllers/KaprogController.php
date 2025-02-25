<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaprogController extends Controller
{
    public function reviewUsulan() {
        return view('kaprog.review.reviewusulan');
    }

    public function show() {
        return view('kaprog.review.detailusulan');
    }

    public function diterima()
    {

        return view('kaprog.review.historyditerima');
    }

    public function ditolak()
    {
        
        return view('kaprog.review.historyditolak');
    }
}
