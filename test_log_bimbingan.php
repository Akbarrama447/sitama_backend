<?php

// Script untuk test API Log Bimbingan Store

$baseUrl = 'http://127.0.0.1:8000';

// 1. Login untuk dapat token
$loginData = [
    'email' => 'test@example.com',
    'password' => 'password'
];

$ch = curl_init($baseUrl . '/api/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($loginData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);

$loginResponse = curl_exec($ch);
$loginData = json_decode($loginResponse, true);

if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
    die("Login failed: " . $loginResponse . "\n");
}

$token = $loginData['token'];
echo "Login berhasil, token: $token\n";

// 2. Store Log Bimbingan
$data = [
    'tanggal' => '2023-10-01',
    'judul' => 'Judul Bimbingan Test',
    'deskripsi' => 'Deskripsi bimbingan test',
    'dosen_nip' => '1981000001',
    'catatan' => 'Catatan opsional'
];

$ch = curl_init($baseUrl . '/api/log-bimbingan');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Form data
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Accept: application/json'
]);

$storeResponse = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo "Response code: $httpCode\n";
echo "Response: $storeResponse\n";

if ($httpCode === 201) {
    echo "Test berhasil!\n";
} else {
    echo "Test gagal!\n";
}
