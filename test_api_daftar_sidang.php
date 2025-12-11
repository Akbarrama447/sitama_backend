<?php
/**
 * Script Testing untuk POST /api/daftar-sidang
 * 
 * Sebelum pake script ini pastiin:
 * 1. Udah ada jadwal sidang di tabel 'jadwal_sidang'
 * 2. User udah login dan punya token sanctum
 * 3. Mahasiswa udah terhubung ke user
 */

// Konfigurasi dasar
$base_url = 'http://localhost:8000'; // Sesuaikan dengan URL aplikasi lu
$api_token = 'YOUR_SANCTUM_TOKEN_HERE'; // Ganti dengan token lu

// Data test
$data_test = [
    'judul' => 'Test Judul Tugas Akhir untuk Pendaftaran Sidang',
    'jadwal_sidang_id' => 1 // Ganti dengan ID jadwal sidang yang valid
];

echo "Testing POST /api/daftar-sidang\n";
echo "Base URL: $base_url\n\n";

// Setup cURL
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $base_url . '/api/daftar-sidang',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data_test),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $api_token,
    ],
]);

// Eksekusi request
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Parse hasil
$result = json_decode($response, true);

// Tampilkan hasil
echo "HTTP Status Code: $http_code\n";
echo "Response:\n";
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";

// Cek respons
if ($http_code === 201) {
    echo "\n✅ SUCCESS: Pendaftaran sidang berhasil!\n";
    echo "ID Sidang: " . $result['data']['sidang_id'] . "\n";
    echo "Judul TA: " . $result['data']['judul_tugas_akhir'] . "\n";
} elseif ($http_code === 422) {
    echo "\n❌ VALIDATION ERROR: Data tidak valid\n";
    foreach ($result['errors'] ?? [] as $field => $messages) {
        echo "- $field: " . implode(', ', $messages) . "\n";
    }
} elseif ($http_code === 400) {
    echo "\n❌ BAD REQUEST: " . ($result['message'] ?? 'Permintaan tidak valid') . "\n";
} elseif ($http_code === 404) {
    echo "\n❌ NOT FOUND: " . ($result['message'] ?? 'Resource tidak ditemukan') . "\n";
} elseif ($http_code === 500) {
    echo "\n💥 SERVER ERROR: " . ($result['message'] ?? 'Terjadi kesalahan server') . "\n";
    if (isset($result['error'])) {
        echo "Detail error: " . $result['error'] . "\n";
    }
} else {
    echo "\n⚠️ STATUS TIDAK DIKETAHUI: $http_code\n";
}

?>