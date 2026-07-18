# Task 3: Penjadwalan Appointment Dokter

## Deskripsi
Mengembangkan fitur pembuatan jadwal pertemuan (appointment) antara pasien dan dokter sesuai dengan PRD.

## Kebutuhan Fungsional
1. **Tabel & Migrasi:** Buat tabel `doctors` dan `appointments` dengan relasi yang sesuai (merujuk ke tabel `users` dan `patients`).
2. **Manajemen Jadwal:** Buat fungsi penambahan jadwal kunjungan pasien ke dokter tertentu pada tanggal dan waktu spesifik.
3. **Validasi:** Cegah adanya jadwal yang bentrok (double booking) pada jam praktek dokter yang sama.
4. **Data Dummy & Seeder:** Buat Seeder untuk tabel `doctors` dan `appointments` dengan berbagai status (scheduled, completed, cancelled) untuk menguji tampilan antrean.

## Aturan Teknis Tambahan
- Pastikan setiap appointment mengacu ke ID pasien dan ID dokter yang valid.
