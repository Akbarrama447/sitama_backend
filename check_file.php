<?php

// Jalankan dari dalam konteks Laravel
// File ini harus dijalankan melalui artisan command atau Laravel route

use Illuminate\Support\Facades\Storage;

// Cek apakah file ada
$filePath = 'public/flutter_apps/flutter_app.apk';
$fileExists = Storage::exists($filePath);

echo "File Path: " . $filePath . "\n";
echo "File Exists: " . ($fileExists ? 'YES' : 'NO') . "\n";

if ($fileExists) {
    $fileSize = Storage::size($filePath);
    $lastModified = Storage::lastModified($filePath);

    echo "File Size: " . $fileSize . " bytes\n";
    echo "Last Modified: " . date('d M Y H:i:s', $lastModified) . "\n";
} else {
    echo "File tidak ditemukan oleh Storage facade\n";
    echo "Mencoba mencari file secara langsung...\n";

    $fullPath = storage_path('app/' . $filePath);
    echo "Full Path: " . $fullPath . "\n";
    echo "File exists (direct): " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
}