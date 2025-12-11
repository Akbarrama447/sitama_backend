<?php
/**
 * Script buat ambil jadwal sidang tersedia
 * (endpoint GET /api/jadwal-sidang/tersedia)
 */

$base_url = 'http://localhost:8000'; // Sesuaikan dengan URL aplikasi lu
$api_token = 'YOUR_SANCTUM_TOKEN_HERE'; // Ganti dengan token lu

echo "Ambil jadwal sidang tersedia...\n";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $base_url . '/api/jadwal-sidang/tersedia',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $api_token,
    ],
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);

echo "HTTP Status Code: $http_code\n";
echo "Response:\n";
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
?>