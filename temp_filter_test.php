<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\RekapAbsensiController;
use Illuminate\Http\Request;
use App\Models\User;

$ctrl = new RekapAbsensiController;
$req = Request::create('/rekap-absensi/filter-options', 'GET', ['konke_id' => 1]);
$req->setUserResolver(function() { return User::first(); });
$res = $ctrl->filterOptions($req);
echo $res->getContent();
