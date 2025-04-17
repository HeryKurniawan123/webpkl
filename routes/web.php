<?php


use App\Models\Cp;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\CpAtpController;
use App\Http\Controllers\HubinController;
use App\Http\Controllers\IdukaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KonkeController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KaprogController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\IdukaAtpController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\PersuratanController;
use App\Http\Controllers\DataPribadiController;
use App\Http\Controllers\UsulanIdukaController;
use App\Http\Controllers\PengajuanPklController;
use App\Http\Controllers\TenagaKependidikanController;
use App\Http\Controllers\DataPribadiPersuratanController;


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

Route::get('/landing-page', function() {
    return view('landing.landing');
});

// Siswa biodata
Route::middleware(['auth', 'hakakses:siswa'])->group(function () {
    Route::get('/dashboard/siswa', [HakAksesController::class, 'siswa'])->name('siswa.dashboard');

    //DATA PRIBADI SISWA
    Route::get('/siswa/data-pribadi', [DataPribadiController::class, 'create'])->name('siswa.data_pribadi.create');
    Route::post('/siswa/data-pribadi', [DataPribadiController::class, 'store'])->name('siswa.data_pribadi.store');

    //USULAN
    Route::get('/form-usulan', [DataController::class, 'dataUsulan'])->name('usulan.index');
    Route::get('/usulan', [UsulanIdukaController::class, 'index'])->name('usulan.index');
    Route::post('/usulan', [UsulanIdukaController::class, 'store'])->name('usulan.store');
    Route::get('/usulan/cetak/{id}', [UsulanIdukaController::class, 'cetakSurat'])->name('usulan.cetakSurat');
    Route::get('/surat-usulan/detail', [DataController::class, 'detailUsulan'])->name('detail.usulan');
    Route::get('/surat-usulan', [DataController::class, 'suratUsulanPDF'])->name('surat.usulan');
    Route::get('/surat-usulan/PDF', [PdfController::class, 'usulanPdf'])->name('usulan.pdf');
    Route::get('/siswa-usulan/PDF', [PdfController::class, 'siswaUsulanPdf'])->name('siswa.usulan.pdf');

    Route::get('/surat-pengajuan/detail', [DataController::class, 'detailPengajuan'])->name('detail.pengajuan');
    Route::get('/data-iduka/usulan', [UsulanIdukaController::class, 'dataIdukaUsulan'])->name('iduka.usulan');

    Route::post('/usulan-iduka/{iduka}', [UsulanIdukaController::class, 'storeAjukanPkl'])->name('usulan.iduka.storeAjukanPkl');

    Route::post('/usulan-iduka/approve/{id}', [UsulanIdukaController::class, 'approvePengajuanPkl'])->name('usulan.iduka.approve');
    Route::post('/usulan-iduka/reject/{id}', [UsulanIdukaController::class, 'rejectPengajuanPkl'])->name('usulan.iduka.reject');
});

Route::middleware(['auth', 'hakakses:hubin'])->group(function () {
    Route::get('/dashboard/hubin', [HakAksesController::class, 'hubin'])->name('hubin.dashboard');

    // SISWA
    Route::get('/data-siswa-detail', [SiswaController::class, 'show'])->name('detail.siswa');
    Route::get('/data-siswa', [SiswaController::class, 'index'])->name('data.siswa');

    //PENGAJUAN
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
    Route::get('/program-keahlian', [DataController::class, 'proker'])->name('proker.index');
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

Route::middleware(['auth', 'hakakses:persuratan'])->group(function () {

    //PENGAJUAN
    Route::get('/pengajuan', [PersuratanController::class, 'index'])->name('pengajuan');

    Route::get('/persuratan/data_pribadi', [DataPribadiPersuratanController::class, 'create'])->name('persuratan.data_pribadi.create');
    Route::post('/persuratan/data_pribadi', [DataPribadiPersuratanController::class, 'store'])->name('persuratan.data_pribadi.store');

    //SURAT PENGANTAR
    Route::get('/surat-pengantar-pdf', [PersuratanController::class, 'suratPengantar'])->name('surat.pengantar');
    Route::get('/surat-pengantar-PDF', [PdfController::class, 'suratPengantarPDF'])->name('surat.pengantarPDF');
   

});

Route::middleware(['auth', 'hakakses:iduka'])->group(function () {


    Route::get('/iduka/data-pribadi', [IdukaController::class, 'dataPribadiIduka'])->name('iduka.data-pribadi');
    Route::get('/iduka/edit', [IdukaController::class, 'edit'])->name('iduka.edit');
    Route::put('/iduka/updatePribadi/{id}', [IdukaController::class, 'updatePribadi'])->name('iduka.updatePribadi');

    Route::get('/iduka-atp', [IdukaAtpController::class, 'index'])->name('tp.iduka');
    Route::post('/iduka-atp/store', [IdukaAtpController::class, 'store'])->name('iduka_atp.store');
    Route::put('/iduka-atp/update/{id}', [IdukaAtpController::class, 'update'])->name('iduka_atp.update');
    Route::delete('/iduka-atp/destroy/{id}', [IdukaAtpController::class, 'destroy'])->name('iduka_atp.destroy');
    Route::get('/get-cp-atp/{konke_id}', function ($konke_id) {
        $cps = Cp::where('konke_id', $konke_id)->with('atp')->get();
        return response()->json($cps);
    });
    Route::get('/iduka_atp/{iduka_id}', [IdukaAtpController::class, 'show'])->name('iduka.tp.tp_show');
    Route::get('/pengajuan-review', [PengajuanPklController::class, 'reviewPengajuan'])->name('pengajuan.review');

    //PEMBIMBING IDUKA
    Route::get('/pembimbing/create', [PembimbingController::class, 'create'])->name('iduka.pembimbing.create');
    Route::post('/pembimbing/store', [PembimbingController::class, 'store'])->name('iduka.pembimbing.store');
    Route::get('/pembimbing/show', [PembimbingController::class, 'show'])->name('iduka.pembimbing.show');
    Route::put('/pembimbing/update/{id}', [PembimbingController::class, 'update'])->name('iduka.pembimbing.update');
    Route::get('/iduka/download-pdf{id}', [IdukaController::class, 'downloadPDF'])->name('iduka.download-pdf');

    Route::get('/data-institusi', [IdukaController::class, 'dataInstitusi'])->name('data.institusi');

    Route::post('/iduka/{id}/store', [IdukaController::class, 'storeInstitusi'])->name('iduka.storeInstitusi');

    // Route::put('/iduka/{id}/update', [IdukaController::class, 'update'])->name('iduka.update');
    Route::put('/iduka/{id}/update-institusi', [IdukaController::class, 'updateInstitusi'])->name('iduka.updateInstitusi');
});


Route::middleware(['auth', 'hakakses:kaprog'])->group(function () {

    //USULAN KAPROG
    Route::get('/review-usulan', [KaprogController::class, 'reviewUsulan'])->name('review.usulan');

    //form usulan
    Route::get('kaprog/review/detail/{id}', [KaprogController::class, 'show'])->name('kaprog.review.detail');

    //pengajuan usulan
    Route::get('/kaprog/review/usulan-pkl/{iduka_id}', [KaprogController::class, 'showDetailPengajuanIduka'])->name('kaprog.review.detailUsulanPkl');
    Route::put('/kaprog/review/usulan-pkl/status/{id}', [KaprogController::class, 'diterimaUsulan'])->name('kaprog.usulan-pkl.status');
    Route::post('/kaprog/update-surat-izin/{id}', [KaprogController::class, 'updateSuratIzin'])->name('kaprog.updateSuratIzin');



    Route::get('/kaprog/review/pengajuan-iduka/{iduka_id}', [KaprogController::class, 'showPengajuanByIduka'])->name('kaprog.review.detailPengajuanByIduka');
    Route::post('/kaprog/review/pengajuan-iduka/{id}', [KaprogController::class, 'verifikasiPengajuan'])->name('kaprog.review.verifikasiPengajuan');


    Route::get('/detail-pengajuan/{id}', [KaprogController::class, 'show'])->name('detail.pengajuan');

    Route::put('/usulan-diterimaUsulan/{id}', [KaprogController::class, 'diterimaUsulan'])->name('usulan.diterimaUsulan');
//cek
    Route::get('/review/pengajuan/kaprog/detail/{iduka_id}', [KaprogController::class, 'detailusulan'])->name('kaprog.review.detailUsulanPkl');
    
    Route::put('/usulan-diterima/{id}', [KaprogController::class, 'diterima'])->name('usulan.diterima');

    Route::put('/usulan-ditolak/{id}', [KaprogController::class, 'ditolak'])->name('usulan.ditolak');

    Route::get('/kaprog/usulan-pkl/detail/{pengajuan}', [KaprogController::class, 'detailPengajuanSiswa'])->name('kaprog.usulan-pkl.detailSiswa');



    //USULAN KAPGROG
    Route::get('/kaprog/usulan', [UsulanIdukaController::class, 'listUsulan'])->name('kaprog.usulan');
    Route::post('/kaprog/usulan/terima/{id}', [UsulanIdukaController::class, 'terima'])->name('kaprog.usulan.terima');
    Route::post('/kaprog/usulan/tolak/{id}', [UsulanIdukaController::class, 'tolak'])->name('kaprog.usulan.tolak');

    //pengajuan iduka
    Route::get('/kaprog/review-pengajuan', [KaprogController::class, 'reviewPengajuan'])->name('kaprog.review.pengajuan');
    Route::get('/kaprog/review-pengajuan/{iduka_id}/detail', [KaprogController::class, 'detailUsulanPkl'])->name('kaprog.review.reviewdetail');
    Route::post('/review/pengajuan/proses/{id}', [KaprogController::class, 'prosesPengajuan'])->name('kaprog.pengajuan.proses');




    Route::get('/kaprog/review/detailUsulan/{id}', [KaprogController::class, 'showUsulan'])->name('kaprog.review.detailUsulan');



    Route::get('/history/diterima', [KaprogController::class, 'historyDiterima'])->name('review.historyditerima');
    Route::get('/history/ditolak', [KaprogController::class, 'historyDitolak'])->name('review.historyditolak');


    //TP
    Route::get('/cp', [CpAtpController::class, 'cp'])->name('cp.index');
    Route::post('/cp', [CpAtpController::class, 'store'])->name('cp.store');
    Route::get('/cp/{id}', [CpAtpController::class, 'show'])->name('cp.show');
    Route::put('/cp/{id}', [CpAtpController::class, 'update'])->name('cp.update');
    Route::delete('/cp/{id}', [CpAtpController::class, 'destroy'])->name('cp.destroy');
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
    Route::get('/iduka/detail/{id}', [IdukaController::class, 'show'])->name('detail.iduka');
    Route::post('/iduka/store', [IdukaController::class, 'store'])->name('iduka.store');
    Route::delete('/iduka/{id}', [IdukaController::class, 'destroy'])->name('iduka.destroy');
    Route::put('/iduka/{id}', [IdukaController::class, 'update'])->name('iduka.update');

    //mengajukan pkl
    Route::post('/pengajuan/{iduka}', [PengajuanPklController::class, 'ajukan'])->name('pengajuan.ajukan');
    Route::get('/pengajuan', [PengajuanPklController::class, 'index'])->name('pengajuan.index');

    Route::get('/detail-pengajuan/{id}', [PengajuanPklController::class, 'showPengajuan'])->name('pengajuan.detail');
    Route::patch('/pengajuan/{id}/terima', [PengajuanPklController::class, 'terima'])->name('pengajuan.terima');
    Route::patch('/pengajuan/{id}/tolak', [PengajuanPklController::class, 'tolak'])->name('pengajuan.tolak');
    Route::get('/review/pengajuan/diterima', [PengajuanPklController::class, 'reviewPengajuanDiterima'])->name('review.pengajuanditerima');
    Route::get('/review/pengajuan/ditolak', [PengajuanPklController::class, 'reviewPengajuanDitolak'])->name('review.pengajuanditolak');



    Route::get('/data-pribadi/iduka', [IdukaController::class, 'dataPribadiIduka'])->name('iduka.pribadi');
    Route::get('/edit/data-pribadi/iduka', [IdukaController::class, 'editDataPribadiIduka'])->name('edit.iduka.pribadi');

    //ORTU
    Route::get('/data-ortu-create', [OrtuController::class])->name('ortu.create');

    //persuratan
    Route::get('/pengajuan', [PersuratanController::class, 'index'])->name('pengajuan');
    Route::get('/review-pengajuan/iduka', [PersuratanController::class, 'reviewPengajuan'])->name('persuratan.review');
    Route::get('/review/persuratan/pengajuan/detail/{iduka_id}', [PersuratanController::class, 'detailUsulan'])->name('persuratan.review.detailUsulanPkl');
    
    Route::get('/detail-Surat-Pengajuan/{id}', [PersuratanController::class, 'show'])->name('persuratan.suratPengajuan.detailSuratPengajuan');
    Route::get('/persuratan/download/{id}', [PersuratanController::class, 'downloadPdf'])
        ->name('persuratan.download');
    Route::get('/persuratan/data-pribadi', [PersuratanController::class, 'create'])->name('persuratan.data_pribadi.create');
    Route::get('/pengajuan-iduka-baru', [PersuratanController::class, 'idukaBaru'])->name('pengajuan.iduka');
    Route::get('/detail-iduka-baru', [PersuratanController::class, 'showidukaBaru'])->name('detail.iduka.baru');

    //konfirmasi persuratan
    Route::post('/review/pengajuan/proses/{id}', [PersuratanController::class, 'prosesPengajuan'])->name('persuratan.pengajuan.proses');


    
    Route::get('/iduka/{id}', [UsulanIdukaController::class, 'detailIdukaUsulan'])->name('detail.datausulan');
});

// // HAK AKSES : HUBIN
// Route::middleware(['auth', 'hakakses:hubin'])->group(function(){


// });

Route::get('/logout', [HakAksesController::class, 'logout'])->name('logout');
