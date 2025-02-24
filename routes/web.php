<?php

use App\Http\Controllers\TenagaKependidikanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

use App\Http\Controllers\OrtuController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HubinController;
use App\Http\Controllers\IdukaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KonkeController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\DataPribadiController;
use App\Http\Controllers\PersuratanController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [HakAksesController::class, 'index'])->name('login');
    Route::post('/login', [HakAksesController::class, 'login']);
});

Route::get('/home', function () {
    return redirect('/logout');
});

// Siswa biodata
Route::middleware(['auth', 'hakakses:siswa'])->group(function () {
    Route::get('/dashboard/siswa', [HakAksesController::class, 'siswa'])->name('siswa.dashboard');

    Route::get('/siswa/data-pribadi', [DataPribadiController::class, 'create'])->name('siswa.data_pribadi.create');
    Route::post('/siswa/data-pribadi', [DataPribadiController::class, 'store'])->name('siswa.data_pribadi.store');

    //USULAN
    Route::get('/form-usulan', [DataController::class, 'dataUsulan'])->name('usulan.index');

});

Route::middleware(['auth', 'hakakses:hubin'])->group(function () {
    Route::get('/dashboard/hubin', [HakAksesController::class, 'hubin'])->name('hubin.dashboard');

    // SISWA
    Route::get('/data-siswa-detail', [SiswaController::class, 'show'])->name('detail.siswa');
    Route::get('/data-siswa', [SiswaController::class, 'index'])->name('data.siswa');
    Route::get('/review-pengajuan', [HubinController::class, 'index'])->name('review.pengajuan');
    Route::get('/detail-pengajuan', [HubinController::class, 'show'])->name('detail.pengajuan');
    Route::get('/history/diterima', [HubinController::class, 'diterima'])->name('history.diterima');
    Route::get('/history/ditolak', [HubinController::class, 'ditolak'])->name('history.ditolak');


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
    Route::get('/proker', [ProkerController::class, 'index'])->name('proker.index');
    Route::post('/proker', [ProkerController::class, 'store'])->name('proker.store');
    Route::put('/proker/{proker}', [ProkerController::class, 'update'])->name('proker.update');
    Route::delete('/proker/{proker}', [ProkerController::class, 'destroy'])->name('proker.destroy');

    //KONKE
    Route::get('/konsentrasi-keahlian', [DataController::class, 'konke'])->name('konke.index');
    Route::get('/konke', [KonkeController::class, 'index'])->name('konke.index');
    Route::post('/konke', [KonkeController::class, 'store'])->name('konke.store');
    Route::put('/konke/{konke}', [KonkeController::class, 'update'])->name('konke.update');
    Route::delete('/konke/{konke}', [KonkeController::class, 'destroy'])->name('konke.destroy');

    //KELAS
    Route::get('/data-kelas', [DataController::class, 'kelas'])->name('kelas.index');
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::put('/kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    Route::get('/siswa/{id}/kelas', [KelasController::class, 'showSiswa'])->name('siswa.kelas');

    //GURU
    Route::get('/data-guru', [GuruController::class, 'dataguru'])->name('guru.index');
    Route::get('/data-guru/detail', [GuruController::class, 'detailGuru'])->name('guru.detail');
    Route::get('/create', [GuruController::class, 'create'])->name('guru.create');
    Route::post('/store', [GuruController::class, 'store'])->name('guru.store');
    Route::get('/data-guru/{guru}/edit', [GuruController::class, 'edit'])->name('guru.edit');
    Route::put('/data-guru/{guru}/update', [GuruController::class, 'update'])->name('guru.update');
    Route::delete('/data-guru/{guru}', [GuruController::class, 'destroy'])->name('guru.destroy');

    //TK 
    Route::get('/data-tenaga-kependidikan', [TenagaKependidikanController::class, 'tenagaKependidikan'])->name('tk.index');
    Route::get('/kependik/create', [TenagaKependidikanController::class, 'create'])->name('kependik.create');
    Route::post('/kependik/store', [TenagaKependidikanController::class, 'store'])->name('kependik.store');
    Route::get('/kependik/{id}/edit', [TenagaKependidikanController::class, 'edit'])->name('kependik.edit');
    Route::put('/kependik/{id}', [TenagaKependidikanController::class, 'update'])->name('kependik.update');
    Route::delete('/kependik/{id}', [TenagaKependidikanController::class, 'destroy'])->name('kependik.destroy');




    Route::get('/siswa/{id}/detail', [SiswaController::class, 'show'])->name('siswa.detail');
});

Route::middleware(['auth', 'hakakses:persuratan'])->group(function() {
    Route::get('/pengajuan', [PersuratanController::class, 'index'])->name('pengajuan');
    Route::get('/detail-Surat-Pengajuan', [PersuratanController::class, 'show'])->name('detail.suratpengajuan');

    Route::post('/download-pdf', [PersuratanController::class, 'downloadPdf'])->name('download.pdf');

    
});


Route::middleware(['auth'])->group(function () {


    Route::get('/dashboard/kaprog', [HakAksesController::class, 'kaprog'])->name('kaprog.dashboard');
    Route::get('/dashboard/iduka', [HakAksesController::class, 'iduka'])->name('iduka.dashboard');
    Route::get('/dashboard/guru', [HakAksesController::class, 'guru'])->name('guru.dashboard');
    Route::get('/dashboard/persuratan', [HakAksesController::class, 'persuratan'])->name('persuratan.dashboard');
    Route::get('/dashboard/pembmbingpkl', [HakAksesController::class, 'ppkl'])->name('ppkl.dashboard');
    Route::get('/dashboard/orangtua', [HakAksesController::class, 'orangtua'])->name('orangtua.dashboard');
    Route::get('/dashboard/pembimbingsekolah', [HakAksesController::class, 'psekolah'])->name('psekolah.dashboard');

    // IDUKA
    Route::get('/data-iduka', [IdukaController::class, 'index'])->name('data.iduka');
    Route::get('/iduka/{id}', [IdukaController::class, 'show'])->name('detail.iduka');
    Route::post('/iduka/store', [IdukaController::class, 'store'])->name('iduka.store');
    Route::delete('/iduka/{id}', [IdukaController::class, 'destroy'])->name('iduka.destroy');
    Route::put('/iduka/{id}', [IdukaController::class, 'update'])->name('iduka.update');




    //ORTU
    Route::get('/data-ortu-create', [OrtuController::class])->name('ortu.create');
});

// // HAK AKSES : HUBIN
// Route::middleware(['auth', 'hakakses:hubin'])->group(function(){


// });

Route::get('/logout', [HakAksesController::class, 'logout'])->name('logout');
