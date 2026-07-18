# Task 4: Rekam Medis Digital

## Deskripsi
Membangun modul pencatatan riwayat kesehatan / rekam medis (medical records) dan diagnosis pasien yang terintegrasi.

## Kebutuhan Fungsional
1. **Tabel & Migrasi:** Buat tabel `medical_records` dan `diagnoses`.
2. **Pencatatan Medis:** Sediakan form SOAP (Subjective, Objective, Assessment, Plan). Tanda vital diisi oleh perawat, sedangkan Assessment & Plan diisi oleh dokter.
3. **Kamus Penyakit:** Isi tabel `diagnoses` dengan beberapa daftar penyakit umum.
4. **Visualisasi Data (Seeder):** Generate rekam medis historis dummy yang terhubung dengan pasien dan appointment yang sudah selesai (completed).

## Aturan Teknis Tambahan
- Data rekam medis harus bisa di-lock agar tidak dapat diubah sembarangan setelah di-submit.
