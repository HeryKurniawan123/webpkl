<?php

use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\IdukaController;
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
    Route::get('/hubin', [HakAksesController::class, 'hubin'])->name('hubin');
    Route::get('/siswa', [HakAksesController::class, 'siswa'])->name('siswa');
    Route::get('/kaprog', [HakAksesController::class, 'kaprog'])->name('kaprog');
    Route::get('/iduka', [HakAksesController::class, 'iduka'])->name('iduka');
    Route::get('/guru', [HakAksesController::class, 'guru'])->name('guru');
    Route::get('/persuratan', [HakAksesController::class, 'persuratan'])->name('persuratan');
    Route::get('/pembmbingpkl', [HakAksesController::class, 'ppkl'])->name('ppkl');
    Route::get('/orangtua', [HakAksesController::class, 'orangtua'])->name('orangtua');
    Route::get('/pembimbingsekolah', [HakAksesController::class, 'psekolah'])->name('psekolah');

    // Iduka
    Route::get('/data-iduka', [IdukaController::class, 'index'])->name('data.iduka');
    Route::get('/data-iduka-detail', [IdukaController::class, 'show'])->name('detail.iduka');

    // siswa
    Route::get('/data-siswa', [SiswaController::class, 'index'])->name('data.siswa');
    Route::get('/data-siswa-detail', [SiswaController::class, 'show'])->name('detail.siswa');
});

// Route::middleware(['auth', 'HakAkses:hubin'])->group(function(){
//     Route::get('/data-iduka', [IdukaController::class, 'index'])->name('data.iduka');
//     Route::get('/data-iduka-detail', [IdukaController::class, 'show'])->name('detail.iduka');
// });

Route::get('/logout', [HakAksesController::class, 'logout'])->name('logout');
