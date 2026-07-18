# Task 2: Manajemen Data Pasien

## Deskripsi
Mengembangkan fitur registrasi dan manajemen data profil pasien (CRUD) sesuai dengan rancangan tabel `patients` pada PRD.

## Kebutuhan Fungsional
1. **Tabel & Migrasi:** Buat tabel `patients` dengan struktur kolom sesuai PRD (No RM unik, Nama, NIK, dll).
2. **Pendaftaran Pasien:** Buat form pendaftaran dengan validasi ketat (NIK 16 digit, No RM generate otomatis).
3. **Visualisasi Data (Seeder):** Buat Seeder `PatientSeeder` untuk men-generate minimal 50 data pasien fiktif (menggunakan Faker) agar tabel pasien dapat divisualisasikan dengan baik.
4. **Antarmuka Pengguna:** Buat halaman list pasien (dengan pagination dan search) serta halaman detail rekam identitas.

## Aturan Teknis Tambahan
- Pastikan logika pen-generate-an Nomor Rekam Medis (RM) diletakkan pada layer yang tepat (contoh: Observer atau Service class).
