# Endpoint: POST /api/daftar-sidang

Endpoint ini digunakan untuk melakukan pendaftaran sidang tugas akhir oleh mahasiswa.

## Request
- **Method**: `POST`
- **URL**: `/api/daftar-sidang`
- **Headers**:
  - `Content-Type: application/json`
  - `Accept: application/json`
  - `Authorization: Bearer {SANCTUM_TOKEN}`

## Body Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `judul` | string | ✅ Yes | Judul tugas akhir mahasiswa |
| `jadwal_sidang_id` | integer | ✅ Yes | ID dari jadwal sidang yang dipilih |

## Response Success (201 Created)
```json
{
    "status": "success",
    "message": "Pendaftaran sidang berhasil",
    "data": {
        "sidang_id": 1,
        "tugas_akhir_id": 1,
        "judul_tugas_akhir": "Contoh Judul Tugas Akhir",
        "jadwal_sidang": {
            "id": 1,
            "tanggal": "2025-01-15",
            "sesi": {
                "id": 1,
                "jam_mulai": "09:00",
                "jam_selesai": "10:00"
            },
            "ruangan": {
                "id": 1,
                "nama_ruangan": "Ruang Sidang A"
            }
        },
        "tanggal_daftar": "2025-01-10T10:30:00Z"
    }
}
```

## Response Errors
### Validation Error (422 Unprocessable Entity)
```json
{
    "status": "error",
    "message": "Data tidak valid",
    "errors": {
        "judul": ["The judul field is required."],
        "jadwal_sidang_id": ["The jadwal sidang id field is required."]
    }
}
```

### Bad Request (400)
```json
{
    "status": "error",
    "message": "Mahasiswa sudah terdaftar dalam sidang sebelumnya"
}
```

### Not Found (404)
```json
{
    "status": "error",
    "message": "Mahasiswa tidak ditemukan"
}
```

### Server Error (500)
```json
{
    "status": "error",
    "message": "Terjadi kesalahan saat mendaftar sidang",
    "error": "SQLSTATE[23000]: Integrity constraint violation..."
}
```

## Alur Logika
1. Periksa apakah user adalah mahasiswa terdaftar
2. Validasi input (judul dan ID jadwal sidang)
3. Cek atau buat/update tugas akhir mahasiswa
4. Pastikan mahasiswa belum pernah daftar sidang sebelumnya
5. Verifikasi syarat sidang sudah lengkap
6. Cek kapasitas jadwal sidang (max 10 mahasiswa per jadwal)
7. Buat record di tabel `sidang_tugas_akhir`

## Catatan
- Endpoint ini membutuhkan autentikasi Sanctum
- Jika mahasiswa belum punya tugas akhir, maka akan dibuatkan baru
- Jika mahasiswa sudah punya tugas akhir aktif, maka hanya judulnya yang di-update
- Mekanisme rollback database otomatis jika terjadi error saat proses pendaftaran