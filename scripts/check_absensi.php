<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;

$rolesToTest = ['guru','kaprog','hubin','kepsek'];
$controller = new \App\Http\Controllers\RekapAbsensiController;

foreach ($rolesToTest as $role) {
    $user = User::where('role',$role)->first();
    if (!$user) {
        echo "no $role user found\n";
        continue;
    }
    echo "\n=== testing role $role (user {$user->id}) ===\n";
    \Auth::loginUsingId($user->id);
    $req = new \Illuminate\Http\Request([ 'start_date'=>'2020-01-01','end_date'=>'2025-12-31' ]);
    $res = $controller->data($req);
    $data = $res->getData();
    echo "response keys: ".implode(',', array_keys((array)$data))."\n";
    if (isset($data->data) && count($data->data)) {
        $first = $data->data[0];
        echo "first row user kecakapan: ";
        if (isset($first->user)) {
            echo "user present; kelas=".json_encode($first->user->kelas)." jurusan=".($first->user->jurusan ?? 'n/a')."\n";
        } else {
            echo "no user in row\n";
        }
    } else {
        echo "no data rows returned\n";
    }
    if (isset($data->students)) {
        echo "students extra count=".count($data->students)."\n";
    }

    // for kaprog also test filterOptions endpoint
    if ($role === 'kaprog') {
        echo "kaprog jurusan=" . ($user->jurusan ?? 'NULL') . " konke_id=" . ($user->konke_id ?? 'NULL') . "\n";
        $req2 = new \Illuminate\Http\Request([]);
        $opts = $controller->filterOptions($req2);
        echo "filterOptions response for kaprog:\n";
        print_r($opts->getData());
    }
}
