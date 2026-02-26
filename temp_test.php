<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Foundation\Bootstrap\ConvertEmptyStringsToNull;
// bootstrap the kernel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\RekapAbsensiController;

// create test data
// create a teacher user and also a corresponding guru record (normally done by app logic)
$guruUser = User::factory()->create(['role'=>'guru','name'=>'GuruTest']);
$guruModel = \App\Models\Guru::create(['user_id' => $guruUser->id, 'nama' => 'GuruTest']);
// student points to guru table id; if the application never created a Guru row
// the code will still work because we fall back to user id.
$student = User::factory()->create([
    'role'=>'siswa',
    'name'=>'SiswaTest',
    'nip'=>'12345',
    'pembimbing_id'=>$guruModel->id // try using guruTable id
]);
Absensi::create(['user_id'=>$student->id,'tanggal'=>now(),'status'=>'hadir']);

\Auth::loginUsingId($guru->id);
$response = (new RekapAbsensiController)->data(Request::create('/rekap-absensi/data','GET',[]));
print_r($response->getData());
