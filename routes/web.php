<?php


use App\Http\Controllers\PendampingController;
use App\Models\Cp;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\CpAtpController;
use App\Http\Controllers\DaftarCetakController;
use App\Http\Controllers\DaftarIdukaController;
use App\Http\Controllers\HubinController;
use App\Http\Controllers\IdukaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KonkeController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KaprogController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\IdukaAtpController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\PersuratanController;
use App\Http\Controllers\DataPribadiController;
use App\Http\Controllers\KaprogIdukaController;
use App\Http\Controllers\UsulanIdukaController;
use App\Http\Controllers\PengajuanPklController;
use App\Http\Controllers\PusatbantuanController;
use App\Http\Controllers\SuratPengantarController;
use App\Http\Controllers\TenagaKependidikanController;
use App\Http\Controllers\DataPribadiPersuratanController;
use App\Http\Controllers\KepsekController;
use App\Http\Controllers\PercetakanAtpController;

Route::get('/PKL SMKN 1 Kawali', function () {
    return view('landing.landing');
});

Route::get('/', function () {
    return redirect('/PKL SMKN 1 Kawali');
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

    //MENAMPILKAN DATA IDUKA
    Route::get('/data-iduka/usulan', [UsulanIdukaController::class, 'dataIdukaUsulan'])->name('iduka.usulan');
    //MEMBUAT AJUAN USULAN
    Route::get('/iduka/{id}', [UsulanIdukaController::class, 'detailIdukaUsulan'])->name('detail.datausulan');
    //-------
    Route::post('/usulan-iduka/{iduka}', [UsulanIdukaController::class, 'storeAjukanPkl'])->name('usulan.iduka.storeAjukanPkl');

    Route::post('/usulan-iduka/approve/{id}', [UsulanIdukaController::class, 'approvePengajuanPkl'])->name('usulan.iduka.approve');
    Route::post('/usulan-iduka/reject/{id}', [UsulanIdukaController::class, 'rejectPengajuanPkl'])->name('usulan.iduka.reject');
});

Route::middleware(['auth', 'hakakses:hubin'])->group(function () {
    Route::get('/dashboard/hubin', [HakAksesController::class, 'hubin'])->name('hubin.dashboard');

    // SISWA
    Route::get('/data-siswa-detail', [SiswaController::class, 'show'])->name('detail.siswa');
    Route::get('/data-siswa', [SiswaController::class, 'index'])->name('data.siswa');


    Route::put('/siswa/{id}/update-siswa', [SiswaController::class, 'updateSiswa'])->name('siswa.updateSiswa');

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

    Route::get('/pusat-bantuan', [SuratPengantarController::class, 'index'])->name('pusatbantuan.index');
    Route::post('/pusat-bantuan/store', [SuratPengantarController::class, 'store'])->name('surat.store');
    Route::post('/pusat-bantuan/update/{id}', [SuratPengantarController::class, 'update'])->name('surat.update');

    //data daftar iduka
    Route::get('/daftar/iduka', [KaprogIdukaController::class, 'index'])->name('hubin.iduka.index');
    Route::get('/daftar/iduka/detail/{id}', [KaprogIdukaController::class, 'show'])->name('hubin.detail.iduka');
    Route::get('/download/detail-iduka/PDF/{id}', [PdfController::class, 'unduhDetailIdukaPDF'])->name('detailIduka.pdf');
    Route::post('/iduka/hubin/store', [KaprogIdukaController::class, 'store'])->name('hubin.iduka.store');
    Route::get('/create/data-iduka', [KaprogIdukaController::class, 'create'])->name('hubin.iduka.create');
    Route::get('/iduka/{id}/edit', [KaprogIdukaController::class, 'edit'])->name('hubin.iduka.edit');
    Route::put('/update/{id}', [KaprogIdukaController::class, 'update'])->name('hubin.iduka.update');
    Route::delete('/hapus-iduka/{id}', [KaprogIdukaController::class, 'destroy'])->name('hubin.iduka.destroy');
    Route::get('/hubin/download-atp-iduka/{id}', [KaprogIdukaController::class, 'downloadAtpIduka'])
        ->name('hubin.download.atp');
    Route::put('/setting/iduka/{id}/tanggal', [KaprogIdukaController::class, 'updateTanggal'])->name('hubin.tanggal.update');

    //import data siswa
    Route::get('/siswa/download-template', [SiswaController::class, 'downloadTemplate'])->name('siswa.download-template');

    Route::get('/daftar/data-iduka', [DaftarIdukaController::class, 'index'])->name('hubin.iduka.daftar');
    Route::get('/hubin/daftarcetak', [DaftarCetakController::class, 'index'])->name('hubin.daftarcetak');
    Route::get('/hubin/daftarcetak/download', [DaftarCetakController::class, 'downloadExcel'])->name('hubin.daftarcetak.download');

});

Route::middleware(['auth', 'hakakses:persuratan'])->group(function () {

    //PENGAJUAN
    Route::get('/pengajuan', [PersuratanController::class, 'index'])->name('pengajuan');
    Route::get('/persuratan/data-pribadi', [PersuratanController::class, 'create'])->name('persuratan.data_pribadi.create');

    Route::get('/persuratan/data_pribadi', [DataPribadiPersuratanController::class, 'create'])->name('persuratan.data_pribadi.create');
    Route::post('/persuratan/data_pribadi', [DataPribadiPersuratanController::class, 'store'])->name('persuratan.data_pribadi.store');

    //SURAT PENGANTAR
    Route::get('/surat-pengantar-pdf', [PersuratanController::class, 'suratPengantar'])->name('surat.pengantar');
    Route::get('/surat-pengantar-PDF', [PdfController::class, 'suratPengantarPDF'])->name('surat.pengantarPDF');

    Route::get('/persuratan/download-kelompok/{iduka_id}', [PersuratanController::class, 'downloadKelompokPdf'])->name('download.kelompok.pdf');

    Route::get('/surat-pengantar/pdf/{id}', [SuratPengantarController::class, 'suratPengantarPDF'])->name('surat.pengantar.pdf');

    Route::get('/surat-semuapengantarpdf/{iduka_id}', [SuratPengantarController::class, 'semuasurat'])
        ->name('semua.surat.pdf');

    //persuratan
    Route::get('/pengajuan', [PersuratanController::class, 'index'])->name('pengajuan');
    Route::get('/review-pengajuan/iduka', [PersuratanController::class, 'reviewPengajuan'])->name('persuratan.review');
    Route::get('/review/persuratan/pengajuan/detail/{iduka_id}', [PersuratanController::class, 'detailUsulan'])->name('persuratan.review.detailUsulanPkl');
    Route::get('/review/pengajuan/history-dikirim', [PersuratanController::class, 'historykirim'])->name('persuratan.review.historyDikirim');

    //konfirmasi persuratan
    Route::post('/review/pengajuan/proses/{id}', [PersuratanController::class, 'prosesPengajuan'])->name('persuratan.pengajuan.proses');
    Route::post('/review/pengajuan/kirim-semua/{iduka_id}', [PersuratanController::class, 'kirimSemua'])->name('review.pengajuan.kirimSemua');

    Route::post('/surat-pengantar/cetak-pilihan', [SuratPengantarController::class, 'cetakPilihan'])->name('persuratan.suratPengantar.cetakPilihan');

    //Surat Balasan
    Route::get('/persuratan/suratBalasan', [PersuratanController::class, 'suratBalasan'])->name('persuratan.suratBalasan');
    Route::get('/persuratan/suratBalasan/{iduka_id}/detailbalasan', [PersuratanController::class, 'detailbalasan'])->name('persuratan.suratBalasan.detailbalasan');
    Route::get('/surat-balasan/download/{id}', [PersuratanController::class, 'downloadSuratBalasan'])
        ->name('persuratan.surat-balasan.download');
    Route::get('/surat-balasan/history', [PersuratanController::class, 'historyBalasan'])->name('persuratan.suratBalasan.history');

    Route::get('/data-iduka/atp', [PercetakanAtpController::class, 'index'])->name('cetak.iduka.index');
    Route::get('/iduka/atp/detail/{id}', [PercetakanAtpController::class, 'show'])->name('cetak.iduka');
    Route::get('/persuratan/download-atp-iduka/{id}', [PercetakanAtpController::class, 'downloadAtpIduka'])
        ->name('persuratan.download.atp');
    // Single download
    Route::get('/surat-balasan/download/{id}', [App\Http\Controllers\PersuratanController::class, 'downloadSuratBalasan'])
        ->name('persuratan.suratBalasan.download');

    // Multiple download
    Route::post('/surat-balasan/download-multiple', [App\Http\Controllers\PersuratanController::class, 'downloadMultipleBalasan'])
        ->name('persuratan.suratBalasan.downloadMultiple');
    Route::post('/update-status-surat', [App\Http\Controllers\PersuratanController::class, 'updateStatusSurat'])->name('persuratan.updateStatusSurat');

    Route::post('/surat-balasan/download-massal', [PersuratanController::class, 'massDownload'])->name('persuratan.suratBalasan.massDownload');
});

Route::middleware(['auth', 'hakakses:iduka'])->group(function () {


    Route::get('/data-pribadi/iduka', [IdukaController::class, 'dataPribadiIduka'])->name('iduka.pribadi');
    Route::get('/edit/data-pribadi/iduka', [IdukaController::class, 'editDataPribadiIduka'])->name('edit.iduka.pribadi');

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

    //PEMBIMBING IDUKA
    Route::get('/pembimbing/create', [PembimbingController::class, 'create'])->name('iduka.pembimbing.create');
    Route::post('/pembimbing/store', [PembimbingController::class, 'store'])->name('iduka.pembimbing.store');
    Route::get('/pembimbing/show', [PembimbingController::class, 'show'])->name('iduka.pembimbing.show');
    Route::put('/pembimbing/update/{id}', [PembimbingController::class, 'update'])->name('iduka.pembimbing.update');
    Route::get('/iduka/download-pdf/{id}', [IdukaController::class, 'downloadPDF'])->name('iduka.download-pdf');

    Route::get('/data-institusi', [IdukaController::class, 'dataInstitusi'])->name('data.institusi');

    Route::post('/iduka/{id}/store', [IdukaController::class, 'storeInstitusi'])->name('iduka.storeInstitusi');

    // Route::put('/iduka/{id}/update', [IdukaController::class, 'update'])->name('iduka.update');
    Route::put('/iduka/{id}/update-institusi', [IdukaController::class, 'updateInstitusi'])->name('iduka.updateInstitusi');

    //validasi di iduka
    Route::get('/pengajuan-review', [PengajuanPklController::class, 'reviewPengajuan'])->name('pengajuan.review');
    Route::get('/detail-pengajuan/iduka/{id}', [PengajuanPklController::class, 'showPengajuan'])->name('pengajuan.detail');
    Route::patch('/pengajuan/{id}/terima', [PengajuanPklController::class, 'terima'])->name('pengajuan.terima');
    Route::patch('/pengajuan/{id}/tolak', [PengajuanPklController::class, 'tolak'])->name('pengajuan.tolak');

    Route::get('/review/pengajuan/diterima', [PengajuanPklController::class, 'reviewPengajuanDiterima'])->name('review.pengajuanditerima');
    Route::get('/review/pengajuan/ditolak', [PengajuanPklController::class, 'reviewPengajuanDitolak'])->name('review.pengajuanditolak');

    Route::get('/iduka/daftar/siswa-diterima', [IdukaController::class, 'siswaDiterima'])->name('iduka.siswa.diterima');
});


Route::middleware(['auth', 'hakakses:kaprog'])->group(function () {

    Route::get('/dashboard/kaprog', [HakAksesController::class, 'kaprog'])->name('kaprog.dashboard');
    //sementara
    Route::get('/detail-Surat-Pengajuan/{id}', [PersuratanController::class, 'show'])->name('persuratan.suratPengajuan.detailSuratPengajuan');

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
    Route::put('/usulan-diterimaUsulanIduka/{id}', [KaprogController::class, 'diterimaUsulanIduka'])->name('usulan.diterimaUsulanIduka');
    Route::post('/kaprog/persetujuan-pembatalan', [KaprogController::class, 'persetujuanPembatalan'])->name('kaprog.persetujuan-pembatalan');

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
    Route::post('/review/pengajuan/{id}', [KaprogController::class, 'prosesPengajuan'])->name('kaprog.pengajuan.prosesPengajuan');
    Route::post('/kaprog/review/kirim-semua/{iduka_id}', [KaprogController::class, 'kirimSemua'])->name('kaprog.review.kirimSemua');
    Route::get('/kaprog/review/detailUsulan/{id}', [KaprogController::class, 'showUsulan'])->name('kaprog.review.detailUsulan');
    Route::get('/history/diterima', [KaprogController::class, 'historyDiterima'])->name('review.historyditerima');
    Route::get('/history/ditolak', [KaprogController::class, 'historyDitolak'])->name('review.historyditolak');

    Route::post('/kaprog/pembatalan/terima/{id}', [KaprogController::class, 'terimaPembatalan'])->name('kaprog.pembatalan.terima');
    Route::post('/kaprog/pembatalan/tolak/{id}', [KaprogController::class, 'tolakPembatalan'])->name('kaprog.pembatalan.tolak');

      Route::get('/kaprog/siswa/{id}/detail', [SiswaController::class, 'show'])->name('kaprog.siswa.detail');
          Route::get('/kaprog/siswa', [SiswaController::class, 'index'])->name('kaprog.siswa.index');


    //TP
    Route::get('/cp', [CpAtpController::class, 'cp'])->name('cp.index');
    Route::post('/cp', [CpAtpController::class, 'store'])->name('cp.store');
    Route::get('/cp/{id}', [CpAtpController::class, 'show'])->name('cp.show');
    Route::put('/cp/{id}', [CpAtpController::class, 'update'])->name('cp.update');
    Route::delete('/cp/{id}', [CpAtpController::class, 'destroy'])->name('cp.destroy');
    Route::get('/kaprog/download-atp-iduka/{id}', [IdukaController::class, 'downloadAtpIduka'])
        ->name('kaprog.download.atp');

    // DATA IDUKA LOG KAPROG dan hubin
    Route::get('/data-iduka', [IdukaController::class, 'index'])->name('data.iduka');
    Route::get('/iduka/detail/{id}', [IdukaController::class, 'show'])->name('detail.iduka');
    Route::post('/iduka/store', [IdukaController::class, 'store'])->name('iduka.store');
    Route::get('/data-iduka/{id}/edit', [IdukaController::class, 'editiduka'])->name('iduka.edit');

    Route::put('/iduka/{id}', [IdukaController::class, 'update'])->name('iduka.update');

    Route::put('/iduka/{id}/tanggal', [IdukaController::class, 'updateTanggal'])->name('kaprog.tanggal.update');
    //--------

    Route::get('/kaprog/histori-pengajuan', [KaprogController::class, 'historiPengajuan'])->name('kaprog.review.histori');



});


Route::middleware(['auth'])->group(function () {
    //untuk hidden/unhidden
    Route::put('/iduka/{iduka}/toggle-visibility', [KaprogController::class, 'toggleVisibility'])
->name('iduka.toggleVisibility');
    //sreach iduka di kaprog/hubin
     Route::get('/iduka', [IdukaController::class, 'index'])->name('iduka.index');

    //update data iduka yang ada di hubin dan kaprog
    Route::put('/iduka-update/{id}', [IdukaController::class, 'updateiduka'])->name('updateiduka.update');
    Route::delete('/iduka/{id}', [IdukaController::class, 'destroy'])->name('iduka.destroy');

    Route::get('/dashboard/kaprog', [HakAksesController::class, 'kaprog'])->name('kaprog.dashboard');
    Route::get('/dashboard/iduka', [HakAksesController::class, 'iduka'])->name('iduka.dashboard');
    Route::get('/dashboard/guru', [HakAksesController::class, 'guru'])->name('guru.dashboard');
    Route::get('/dashboard/persuratan', [HakAksesController::class, 'persuratan'])->name('persuratan.dashboard');
    Route::get('/dashboard/pembmbingpkl', [HakAksesController::class, 'ppkl'])->name('ppkl.dashboard');
    Route::get('/dashboard/orangtua', [HakAksesController::class, 'orangtua'])->name('orangtua.dashboard');
    Route::get('/dashboard/pembimbingsekolah', [HakAksesController::class, 'psekolah'])->name('psekolah.dashboard');
    Route::get('/dashboard/kepsek', [HakAksesController::class, 'kepsek'])->name('kepsek.dashboard');
    Route::get('/dashboard/pendamping', [HakAksesController::class, 'pendamping'])->name('pendamping.dashboard');

    //mengajukan pkl
    Route::post('/pengajuan/{iduka}', [PengajuanPklController::class, 'ajukan'])->name('pengajuan.ajukan');
    Route::get('/pengajuan', [PengajuanPklController::class, 'index'])->name('pengajuan.index');

    //ORTU
    Route::get('/data-ortu-create', [OrtuController::class])->name('ortu.create');
    Route::get('/persuratan/download/{id}', [PersuratanController::class, 'downloadPdf'])
        ->name('persuratan.download');

    // membuat data persuratan    
    Route::get('/pengajuan-iduka-baru', [PersuratanController::class, 'idukaBaru'])->name('pengajuan.iduka');
    Route::get('/detail-iduka-baru', [PersuratanController::class, 'showidukaBaru'])->name('detail.iduka.baru');

    //profill
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');

    Route::get('/kaprog/pengajuan/pembatalan', [PengajuanPklController::class, 'listPembatalan'])->name('kaprog.pengajuan.pembatalan');
    Route::put('/kaprog/pengajuan/pembatalan/{id}/tolak', [PengajuanPklController::class, 'tolakPembatalan'])->name('kaprog.pengajuan.tolakPembatalan');
    Route::put('/kaprog/pengajuan/{id}/setujui-pembatalan', [PengajuanPklController::class, 'setujuiPembatalan'])->name('kaprog.pengajuan.setujuiPembatalan');
    Route::post('/siswa/pengajuan/{id}/batal', [PengajuanPklController::class, 'ajukanPembatalan'])->name('siswa.pengajuan.ajukanPembatalan');
});

//Pendamping
Route::middleware(['auth', 'hakakses:pendamping'])->group(function () {

    Route::get('/data-iduka/pendamping', [PendampingController::class, 'dataIdukaPendamping'])->name('pendamping.iduka.index');
    Route::get('/data-siswa/pendamping', [PendampingController::class, 'dataSiswaPendamping'])->name('pendamping.kelas.index');
    Route::get('/data-guru/pendamping', [PendampingController::class, 'dataGuruPendamping'])->name('pendamping.guru.index');
    Route::get('/data-tenaga-kependidikan/pendamping', [PendampingController::class, 'dataTKPembimbing'])->name('pendamping.tk.index');
});

//Kepsek
Route::middleware(['auth', 'hakakses:kepsek'])->group(function () {
    Route::get('/data-iduka/kepsek', [KepsekController::class, 'dataIdukaKepsek'])->name('kepsek.iduka.index');
    Route::get('/data-siswa/kepsek', [KepsekController::class, 'dataSiswaKepsek'])->name('kepsek.kelas.index');
    Route::get('/data-guru/kepsek', [KepsekController::class, 'dataGuruKepsek'])->name('kepsek.guru.index');
    Route::get('/data-tenaga-kependidikan/kepsek', [KepsekController::class, 'dataTKKepsek'])->name('kepsek.tk.index');
    Route::get('/kepsek/daftar/iduka/detail/{id}', [KepsekController::class, 'show'])->name('kepsek.detail.iduka');
     Route::get('/kepsek/histori-pengajuan', [KepsekController::class, 'historiPengajuan'])->name('kepsek.reviewPengajuanSiswa');
         Route::get('kepsek/iduka/detail/{id}', [IdukaController::class, 'show'])->name('kepsek.detail.iduka');
            Route::get('/kepsek/siswa/{id}/detail', [SiswaController::class, 'show'])->name('kepsek.siswa.detail');
            
    Route::get('/kepsek/siswa', [SiswaController::class, 'index'])->name('kepsek.siswa.index');
});

Route::get('/logout', [HakAksesController::class, 'logout'])->name('logout');



// admin

// teknisi

// guru

//LATIHAN
//YTYTYFYDIO
//HFDFSHRTERRS//
//HFFYHGJGUGFUFUG
//GDGDGGDGDGDGDG
//YFYYYTETSRRR
//JUFYDDDTDITO g
