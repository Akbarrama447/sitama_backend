<?php
require_once __DIR__.'/vendor/autoload.php';

// Setup Laravel Artisan-style environment
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TugasAkhir;

// Ambil salah satu TA buat test method syaratSidangLengkap
$tugasAkhir = TugasAkhir::first();

if ($tugasAkhir) {
    echo "Testing method syaratSidangLengkap() pada TugasAkhir ID: {$tugasAkhir->id}\n";
    
    try {
        $hasil = $tugasAkhir->syaratSidangLengkap();
        echo "Hasil: " . ($hasil ? 'true' : 'false') . "\n";
        echo "✅ Method syaratSidangLengkap() BERHASIL dijalankan\n";
    } catch (Exception $e) {
        echo "❌ ERROR: " . $e->getMessage() . "\n";
    }
} else {
    echo "⚠️ Ga ada TugasAkhir di database buat test\n";
    echo "Silakan buat dulu data TugasAkhir minimal satu row di tabel tugas_akhir\n";
}