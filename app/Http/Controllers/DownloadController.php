<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Menampilkan halaman download aplikasi Flutter
     */
    public function index()
    {
        // Dapatkan informasi file aplikasi jika ada
        $fileName = 'flutter_app.apk'; // Nama default file aplikasi
        $filePath = 'public/flutter_apps/' . $fileName; // Lokasi penyimpanan file

        $fileExists = Storage::exists($filePath);
        $fileSize = $fileExists ? Storage::size($filePath) : null;
        $lastModified = $fileExists ? Storage::lastModified($filePath) : null;

        // Dapatkan informasi file sitama.apk dari direktori public
        $apkPath = public_path('sitama.apk');
        $apkExists = file_exists($apkPath);
        $apkSize = $apkExists ? filesize($apkPath) : null;
        $apkLastModified = $apkExists ? filemtime($apkPath) : null;

        return view('download.index', [
            'fileName' => $fileName,
            'fileExists' => $fileExists,
            'fileSize' => $fileSize ? $this->formatBytes($fileSize) : null,
            'lastModified' => $lastModified ? date('d M Y H:i', $lastModified) : null,
            'apkExists' => $apkExists,
            'apkSize' => $apkSize ? $this->formatBytes($apkSize) : null,
            'apkLastModified' => $apkLastModified ? date('d M Y H:i', $apkLastModified) : null
        ]);
    }
    
    /**
     * Melakukan download aplikasi Flutter
     */
    public function downloadApp()
    {
        $fileName = 'flutter_app.apk'; // Nama file aplikasi
        $filePath = 'public/flutter_apps/' . $fileName;

        // Cek apakah file ada
        if (!Storage::exists($filePath)) {
            return redirect()->back()->with('error', 'File aplikasi tidak ditemukan.');
        }

        // Lakukan download
        return Storage::download($filePath, $fileName, [
            'Content-Type' => 'application/vnd.android.package-archive'
        ]);
    }
    
    /**
     * Format ukuran file dalam bytes ke format yang lebih mudah dibaca
     */
    private function formatBytes($size, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB');

        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }

    /**
     * Melakukan download file sitama.apk dari direktori public
     */
    public function downloadApk()
    {
        $fileName = 'sitama.apk'; // Nama file APK
        $filePath = public_path($fileName); // Lokasi file di direktori public

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File aplikasi tidak ditemukan.');
        }

        // Lakukan download
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/vnd.android.package-archive'
        ]);
    }

    /**
     * Format ukuran file dalam bytes ke format yang lebih mudah dibaca (fungsi static untuk digunakan di view)
     */
    public static function formatBytesStatic($size, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB');

        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }
}