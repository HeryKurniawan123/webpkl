<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Http\Controllers\RekapAbsensiController;

// Find a guru user
$guru = User::where('role', 'guru')->first();
if (!$guru) {
    echo "No guru user found\n";
    exit(1);
}

echo "Testing export for guru: {$guru->name} (ID {$guru->id})\n";

// Simulate request
\Auth::loginUsingId($guru->id);
$user = \Auth::user();
$role = $user->role;
$guruId = optional($user->guru)->id ?: $user->id;

// This mimics the logic in exportPerKelas for guru role
if ($role === 'guru') {
    $gurName = $user->name ?? 'Guru';
    $konkeName = 'Bimbingan - ' . $gurName;
    $parts = ['rekapabsen_bimbingan'];
    $parts[] = preg_replace('/[^A-Za-z0-9_\-]/', '_', str_replace(' ', '_', strtolower($gurName)));
    if ('2026-01-01') $parts[] = '2026-01-01';
    if ('2026-02-28') $parts[] = '2026-02-28';
    $fileName = implode('_', $parts) . '_' . date('Ymd_His') . '.xlsx';

    echo "Filename: $fileName\n";
    echo "konkeName for title: $konkeName\n";

    // Create export object
    $export = new \App\Exports\DataAbsenPerKelas('2026-01-01', '2026-02-28', null, null, $guruId, $konkeName, null);
    echo "Export object created successfully\n";
}
?>
