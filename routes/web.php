<?php

use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\IdukaController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['guest'])->group(function(){
    Route::get('/login', [HakAksesController::class, 'index'])->name('login');
    Route::post('/login', [HakAksesController::class, 'login']);
});

Route::get('/home', function(){
    return redirect('/logout');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard/hubin', [HakAksesController::class, 'hubin'])->name('hubin.dashboard');
    Route::get('/dashboard/siswa', [HakAksesController::class, 'siswa'])->name('siswa.dashboard');
    Route::get('/dashboard/kaprog', [HakAksesController::class, 'kaprog'])->name('kaprog.dashboard');
    Route::get('/dashboard/iduka', [HakAksesController::class, 'iduka'])->name('iduka.dashboard');
    Route::get('/dashboard/guru', [HakAksesController::class, 'guru'])->name('guru.dashboard');
    Route::get('/dashboard/persuratan', [HakAksesController::class, 'persuratan'])->name('persuratan.dashboard');
    Route::get('/dashboard/pembmbingpkl', [HakAksesController::class, 'ppkl'])->name('ppkl.dashboard');
    Route::get('/dashboard/orangtua', [HakAksesController::class, 'orangtua'])->name('orangtua.dashboard');
    Route::get('/dashboard/pembimbingsekolah', [HakAksesController::class, 'psekolah'])->name('psekolah.dashboard');

    // IDUKA
    Route::get('/data-iduka', [IdukaController::class, 'index'])->name('data.iduka');
    Route::get('/data-iduka-detail', [IdukaController::class, 'show'])->name('detail.iduka');

    // SISWA
    Route::get('/data-siswa-detail', [SiswaController::class, 'show'])->name('detail.siswa');
    Route::get('/data-siswa', [SiswaController::class, 'index'])->name('data.siswa');

    //ORTU
    Route::get('/data-ortu-create',[OrtuController::class])->name('ortu.create');
});

// // HAK AKSES : HUBIN
// Route::middleware(['auth', 'hakakses:hubin'])->group(function(){


// });

Route::get('/logout', [HakAksesController::class, 'logout'])->name('logout');
