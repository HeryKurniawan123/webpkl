<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\IdukaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\DataPribadiController;


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

// Siswa biodata
Route::middleware(['auth', 'hakakses:siswa'])->group(function () {
    Route::get('/dashboard/siswa', [HakAksesController::class, 'siswa'])->name('siswa.dashboard');

    Route::get('/siswa/data-pribadi', [DataPribadiController::class, 'create'])->name('siswa.data_pribadi.create');
    Route::post('/siswa/data-pribadi', [DataPribadiController::class, 'store'])->name('siswa.data_pribadi.store');
});

Route::middleware(['auth', 'hakakses:hubin'])->group(function () {
    Route::get('/dashboard/hubin', [HakAksesController::class, 'hubin'])->name('hubin.dashboard');

    // SISWA
    Route::get('/data-siswa-detail', [SiswaController::class, 'show'])->name('detail.siswa');
    Route::get('/data-siswa', [SiswaController::class, 'index'])->name('data.siswa');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/import-siswa', [SiswaController::class, 'importExcel'])->name('siswa.import');
    Route::put('/siswa/data_pribadi/{id}', [DataPribadiController::class, 'update'])->name('siswa.data_pribadi.update');
    Route::get('/siswa/{id}/detail', [SiswaController::class, 'show'])->name('siswa.detail');
    Route::get('/data-siswa-kelas', [SiswaController::class, 'showSiswa'])->name('siswa.kelas');

    //PROKER
    Route::get('/program-kerja', [DataController::class, 'proker'])->name('proker.index');

    //KONKE
    Route::get('/konsentrasi-keahlian', [DataController::class, 'konke'])->name('konke.index');

    //KELAS
    Route::get('/data-kelas', [DataController::class, 'kelas'])->name('kelas.index');
});

Route::middleware(['auth'])->group(function(){
   
    
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

   

    //ORTU
    Route::get('/data-ortu-create',[OrtuController::class])->name('ortu.create');
});

// // HAK AKSES : HUBIN
// Route::middleware(['auth', 'hakakses:hubin'])->group(function(){


// });

Route::get('/logout', [HakAksesController::class, 'logout'])->name('logout');
