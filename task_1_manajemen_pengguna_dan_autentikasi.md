# Task 1: Manajemen Pengguna dan Autentikasi

## Deskripsi
Menyesuaikan sistem autentikasi dan manajemen pengguna (user management) yang sudah ada di Laravel agar selaras dengan PRD.md, khususnya terkait peran pengguna (user role).

## Kebutuhan Fungsional
1. **Penyesuaian Struktur Tabel:** Sesuaikan tabel `users` dan tabel relasi/roles agar mencakup hak akses untuk: Admin, Dokter, dan Perawat.
2. **Data Dummy & Seeder:** Buat atau perbarui data dummy untuk setiap role (Admin, Dokter, Perawat) menggunakan Seeder untuk keperluan visualisasi.
3. **CRUD User:** Sesuaikan logika Create, Read, Update, dan Delete pengguna agar mengenali dan memproses parameter role yang baru.

## Aturan Teknis Tambahan (Strict)
- Wajib mengikuti standar *coding style*, pola arsitektur, dan konvensi penamaan yang sudah ada (existing) pada modul user saat ini.
- **DILARANG** membuat pola baru yang tidak konsisten dengan codebase saat ini.
- Gunakan Eloquent ORM untuk pengelolaan database.
